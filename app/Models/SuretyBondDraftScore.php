<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SuretyBondDraftScore extends Model
{
    use HasFactory;
    public $fillable = ['value','category','surety_bond_id','scoring_id','scoring_detail_id'];
    public function surety_bond(){
        return $this->belongsTo(SuretyBondDraft::class);
    }
    public function scoring(){
        return $this->belongsTo(Scoring::class);
    }
    public static function categories(){
        return Scoring::categories();
    }
}
