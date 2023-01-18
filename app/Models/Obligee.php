<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use DB;
use Exception;
use App\Helpers\Jamsyar;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Obligee extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'address',
        'type',
        'city_id',
        'status',
        'jamsyar_id',
        'jamsyar_code'
    ];
    protected $appends = ['type_name'];
    public function typeName(): Attribute
    {
        return Attribute::make(get: fn () => $this->type ? self::types()[$this->type] : null);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public static function types(){
        //disesuaikan dengan dokumentasi jamshar v1.1.0, 12-20-2022 by Imoh
        return [
            '1' => 'SWASTA',
            '2' => 'PEMERINTAH SUMBER DANA APBN APBD',
            '3' => 'BUMN',
            '4' => 'ANAK BUMN',
            '5' => 'BUMD'
        ];
    }
    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'address' => $args->address,
            'type' => $args->type,
            'city_id' => $args->city_id,
            'status' => 'Belum Sinkron',
            'jamsyar_id' => $args->jamsyar_id,
            'jamsyar_code' => $args->jamsyar_code
        ];
    }

    public static function buat(array $params): self{
        return self::create(self::fetch((object)$params));
    }

    public function ubah(array $params): bool{
        return $this->update(self::fetch((object)$params));
    }

    public function hapus(){
        try {
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
        }
    }
    public function sync(){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/add_obligee_sbd' : 'http://192.168.190.168:8002/Api/add_obligee_sbd';
        $response = Http::asJson()->acceptJson()->withToken(Jamsyar::login())
        ->post($url, [
            "nama_obligee" => $this->name,
            "alamat_obligee" => $this->address,
            "propinsi" => $this->city->province_id ?? 17,
            "kota" => $this->city->id ?? 15,
            "jenis_obligee" => 1
        ]);
        if($response->successful()){
            $data = $response->json()['data'];
            return $this->update([
                'jamsyar_code' => $data['kode_unik_obligee'],
                'status' => 'Sinkron',
            ]);
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }

    public static function jamsyar(){
        $nextOffset = true;
        $offset = 0;
        $dataCount = 0;
        while($nextOffset) {
            $response = Jamsyar::obligees([
                "nama_obligee"=> "",
                "kode_unik_obligee"=> "",
                "limit" => 20,
                "offset" => $offset
            ]);
            self::upsert(array_filter(array_map(function($obligee){
                if($obligee['nama_obligee'] && $obligee['alamat_obligee'] && $obligee['kode_unik_obligee']){
                    \Log::info($obligee['nama_obligee'].' '.$obligee['alamat_obligee'].' '.$obligee['kode_unik_obligee']);
                    return [
                        'name' => $obligee['nama_obligee'],
                        'address' => $obligee['alamat_obligee'],
                        'jamsyar_code' => $obligee['kode_unik_obligee'],
                        'status' => 'Sinkron'
                    ];
                }
            },$response['data'])),['jamsyar_code'],['name','address']);
            DB::table('obligees')->update(['created_at' => now(),'updated_at' => now()]);

            if(config('app.env') == 'local'){
                if($dataCount >= 50){
                    $nextOffset = false;
                }else{
                    $dataCount += 20;
                    $offset += 20;
                }
            }else if(config('app.env') == 'production'){
                if($response['total_record'] < 20){
                    $nextOffset = false;
                }else{
                    $dataCount += 20;
                    $offset += 20;
                }
            }
        }
    }
}
