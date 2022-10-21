<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
        ];
    }

    public function bank_accounts()
    {
        return $this->hasMany(BankAccount::class);
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