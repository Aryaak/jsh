<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $fillable = ['name','province_id'];

    public function principals(){
        return $this->hasMany(Principal::class);
    }
    public function obligees(){
        return $this->hasMany(Obligee::class);
    }
    public function province(){
        return $this->belongsTo(Province::class);
    }
}
