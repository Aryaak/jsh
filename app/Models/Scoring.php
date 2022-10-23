<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Scoring extends Model
{
    use HasFactory;

    public $fillable = ['title','category'];
    public static function categories(){
        return ['character','capacity','capital','condition','collateral'];
    }
    public function scoring_details()
    {
        return $this->hasMany(ScoringDetail::class);
    }
}
