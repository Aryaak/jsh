<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Scoring extends Model
{
    use HasFactory;

    public $fillable = ['title','category'];
    public function details(){
        return $this->hasMany(ScoringDetail::class);
    }
    public function principals(){
        return $this->belongsToMany(Principal::class)->withTimestamps();
    }
    public static function categories(){
        return ['character','capacity','capital','condition','collateral'];
    }
}
