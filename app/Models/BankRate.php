<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BankRate extends Model
{
    use HasFactory;
    public $fillable = [
        'min_value',
        'rate_value',
        'polish_cost',
        'stamp_cost',
        'desc',
        'bank_id',
        'insurance_id',
        'insurance_type_id'
    ];
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
    public function insurance(){
        return $this->belongsTo(Insurance::class);
    }
    public function insurance_type(){
        return $this->belongsTo(InsuranceType::class);
    }
    private static function fetch(object $args): array{
        return [
            'min_value' => $args->minValue,
            'rate_value' => $args->rateValue,
            'polish_cost' => $args->polishCost,
            'stamp_cost' => $args->stampCost,
            'desc' => $args->desc,
            'bank_id' => $args->bankId,
            'insurance_id' => $args->insuranceId,
            'insurance_type_id' => $args->insuranceTypeId,
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
