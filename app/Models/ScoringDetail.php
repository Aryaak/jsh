<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ScoringDetail extends Model
{
    use HasFactory;

    public $fillable = ['text','value','scoring_id'];
    public function scoring(){
        return $this->belongsTo(Scoring::class);
    }
}
