<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
    use HasFactory;

    public $fillable = ['code','name'];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
            'code' => $args->code,
        ];
    }
    public function agent_rates(){
        return $this->hasMany(AgentRate::class);
    }
    public function insurance_rates(){
        return $this->hasMany(InsuranceRate::class);
    }
    public function bank_rates(){
        return $this->hasMany(BankRate::class);
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
