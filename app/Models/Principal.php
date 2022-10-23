<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

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
    public function city(){
        return $this->belongsTo(City::class);
    }
    private static function fetch(object $args){
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
            ]
        ];
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $principal = self::create($request->principal);
        return $principal;
        // dd($request);
    }
    public function ubah(array $params): bool{
        return $this->update(self::fetch((object)$params)->principal);
    }
    public function hapus(){
        $this->delete();
    }
}
