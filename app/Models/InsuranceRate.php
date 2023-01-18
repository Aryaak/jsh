<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Exception;

class InsuranceRate extends Model
{
    use HasFactory;

    public $fillable = ['min_value','rate_value','polish_cost','stamp_cost','desc','insurance_id','insurance_type_id'];
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
        try{
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
        }
    }
}
