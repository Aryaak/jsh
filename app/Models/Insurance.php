<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    public $fillable = ['name','alias','address','pc_name','pc_position'];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'alias' => $args->alias,
            'address' => $args->address,
            'pc_name' => $args->pc_name,
            'pc_position' => $args->pc_position,
        ];
    }

    public static function buat(array $params): self{
        return self::create(self::fetch((object)$params));
    }
    public function ubah(array $params): bool{
        return $this->update(self::fetch((object)$params));
    }
    public function hapus(): bool{
        return $this->delete();
    }

}
