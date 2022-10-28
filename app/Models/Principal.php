<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scoring;

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
    public function scorings(){
        return $this->belongsToMany(Scoring::class)->withTimestamps();
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
            ],
            'scoring' => array_values(collect($args->scoring)->map(function($item,$key){return $key;})->all())
        ];
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $principal = self::create($request->principal);
        $principal->scorings()->sync($request->scoring);
        $principal->updateScore();
        return $principal;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        $this->update($request->principal);
        $this->scorings()->sync($request->scoring);
        return $this->updateScore();
    }
    private function updateScore(): bool{
        return $this->update([
            'score' => $this->scorings->count() / Scoring::whereNull('category')->count() * 10
        ]);
    }
    public function hapus(){
        $this->delete();
    }
}
