<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','is_regional','jamsyar_username','jamsyar_password'];
    protected $casts = ['is_regional' => 'boolean',];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'is_regional' => $args->is_regional,
            'slug' => Str::slug($args->name),
            'jamsyar_username' => $args->is_regional ? $args->jamsyar_username : null,
            'jamsyar_password' => $args->is_regional ? $args->jamsyar_password : null,
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
