<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GuaranteeBankDraftScore extends Model
{
    use HasFactory;
    public $fillable = ['value','category','guarantee_bank_draft_id','scoring_id','scoring_detail_id'];
    public function guarantee_bank(){
        return $this->belongsTo(GuaranteeBankDraft::class);
    }
    public function scoring(){
        return $this->belongsTo(Scoring::class);
    }
}
