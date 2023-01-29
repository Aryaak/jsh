<?php

namespace App\Models;

use Exception;
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
        try {
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
        }
    }
}
