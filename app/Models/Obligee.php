<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Obligee extends Model
{
    use HasFactory;

    public $fillable = ['name','address','type','jamsyar_id','jamsyar_code'];
    public static function types(){
        return [];
    }
}
