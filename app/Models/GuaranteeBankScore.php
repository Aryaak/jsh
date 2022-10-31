<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GuaranteeBankScore extends Model
{
    use HasFactory;
    public $fillable = ['value','category','guarantee_bank_id','scoring_id','scoring_detail_id'];
    public function guarantee_bank(){
        return $this->belongsTo(GuaranteeBank::class);
    }
    public function scoring(){
        return $this->belongsTo(Scoring::class);
    }
}
