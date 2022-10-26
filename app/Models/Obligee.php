<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Obligee extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'address',
        'type',
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
}
