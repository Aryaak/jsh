<?php

namespace App\Models;


use DB;
use Exception;
use App\Models\Scoring;
use App\Helpers\Sirius;
use App\Helpers\Jamsyar;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Principal extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'domicile',
        'score',
        'npwp_number',
        'npwp_expired_at',
        'nib_number',
        'nib_expired_at',
        'pic_name',
        'pic_position',
        'jamsyar_id',
        'jamsyar_code',
        'city_id',
    ];

    protected $appends = ['npwp_expired_at_converted', 'nib_expired_at_converted'];

    // Accessors

    public function scoreColor(): Attribute
    {
        return Attribute::make(get: function () {
            return match (true) {
                $this->score >= 6.6 => 'success',
                $this->score >= 3.3 => 'warning',
                default => 'danger',
            };
        });
    }

    public function npwpExpiredAtConverted(): Attribute
    {
        return Attribute::make(get: fn() => $this->npwp_expired_at ? Sirius::toLongDate($this->npwp_expired_at) : null);
    }

    public function nibExpiredAtConverted(): Attribute
    {
        return Attribute::make(get: fn() => $this->nib_expired_at ? Sirius::toLongDate($this->nib_expired_at) : null);
    }

    // Relations

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function certificates(){
        return $this->hasMany(Certificate::class);
    }
    public function certificate(){
        return $this->hasOne(Certificate::class)->latestOfMany();
    }
    public function scorings(){
        return $this->belongsToMany(Scoring::class)->withTimestamps();
    }
    private static function fetch(object $args){
        $certificates = [];
        for ($i=0; $i < count($args->certificate['number']); $i++) {
            $certificates[] = [
                'number' => $args->certificate['number'][$i],
                'expired_at' => $args->certificate['expiredAt'][$i],
            ];
        }
        return (object)[
            'principal' => [
                'name' => $args->info['name'],
                'email' => $args->info['email'],
                'phone' => $args->info['phone'],
                'domicile' => $args->info['domicile'],
                'address' => $args->info['address'],
                'pic_name' => $args->info['picName'],
                'pic_position' => $args->info['picPosition'],
                'npwp_number' => $args->info['npwpNumber'],
                'npwp_expired_at' => $args->info['npwpExpiredAt'],
                'nib_number' => $args->info['nibNumber'],
                'nib_expired_at' => $args->info['nibExpiredAt'],
                'city_id' => $args->info['cityId'],
                'province_id' => $args->info['provinceId'],
                'jamsyar_id' => $args->info['jamsyarId'],
                'jamsyar_code' => $args->info['jamsyarCode'],
                'score' => 0
            ],
            'scoring' => array_values(collect($args->scoring)->map(function($item,$key){return $key;})->all()),
            'certificate' => $certificates,
        ];
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $principal = self::create($request->principal);
        $principal->scorings()->sync($request->scoring);
        $principal->certificates()->createMany($request->certificate);
        $principal->updateScore();
        return $principal;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        $this->update($request->principal);
        $this->scorings()->sync($request->scoring);
        $this->certificates()->delete();
        $this->certificates()->createMany($request->certificate);
        return $this->updateScore();
    }
    private function updateScore(): bool{
        return $this->update([
            'score' => $this->scorings->count() / Scoring::whereNull('category')->count() * 10
        ]);
    }
    public function hapus(){
        try {
            $this->scorings()->detach();
            $this->certificates()->delete();
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan data lain", 422);
        }
    }
    public function sync(){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/add_principal_sbd' : 'http://192.168.190.168:8002/Api/add_principal_sbd';
        $response = Http::asJson()->acceptJson()->withToken(Jamsyar::login())
        ->post($url, [
            "nama_principal" => $this->name,
            "alamat_principal" => $this->address,
            "npwp_principal" => $this->npwp_number,
            "email_principal" => $this->email,
            "jenis_obligee" => 1,
            "nama_penanggung_jawab" => $this->pic_name,
            "jabatan_penanggung_jawab" => $this->pic_position
        ]);
        dd($response->json());
        if($response->successful()){
            return $response->json();
        }else{
            // throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    public static function jamsyar(){
        $nextOffset = true;
        $offset = 0;
        $dataCount = 0;
        while($nextOffset) {
            $response = Jamsyar::principals([
                "nama_principal"=> "",
                "kode_unik_principal"=> "",
                "limit" => 20,
                "offset" => $offset
            ]);
            self::upsert(array_filter(array_map(function($principal){
                \Log::info($principal['nama_principal'].' '.$principal['alamat_principal'].' '.$principal['kode_unik_principal']);
                if($principal['nama_principal'] && $principal['alamat_principal'] && $principal['kode_unik_principal']){
                    return [
                        'name' => $principal['nama_principal'],
                        'address' => $principal['alamat_principal'],
                        'jamsyar_code' => $principal['kode_unik_principal'],
                    ];
                }
            },$response['data'])),['jamsyar_code'],['name','address']);
            DB::table('principals')->update(['created_at' => now(),'updated_at' => now()]);

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
