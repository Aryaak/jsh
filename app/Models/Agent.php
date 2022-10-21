<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'identity_number',
        'is_active',
        'is_verified',
        'jamsyar_username',
        'jamsyar_password',
        'branch_id'
    ];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'phone' => $args->phone,
            'email' => $args->email,
            'address' => $args->address,
            'identity_number' => $args->identity_number,
            'is_active' => $args->is_active,
            'is_verified' => $args->is_verified,
            'jamsyar_username' => $args->jamsyar_username,
            'jamsyar_password' => $args->jamsyar_password,
            'branch_id' => $args->branch_id,
        ];
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function bank_accounts()
    {
        return $this->hasOne(BankAccount::class,'agent_id');
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
