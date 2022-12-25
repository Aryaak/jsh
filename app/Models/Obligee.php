<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return Attribute::make(get: fn () => self::types()[$this->type]);
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
        $this->delete();
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
}
