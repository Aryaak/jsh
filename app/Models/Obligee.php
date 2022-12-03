<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Exception;
use App\Helpers\Jamsyar;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

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

    public function city(){
        return $this->belongsTo(City::class);
    }

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'address' => $args->address,
            'type' => $args->type,
            'city_id' => $args->city_id,
            'status' => 'Sinkron',
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
            "propinsi" => 17,
            "kota" => 15,
            "jenis_obligee" => 1
        ]);
        dd($response->json());
        if($response->successful()){
            return $response->json();
        }else{
            // throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
}
