<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $fillable = ['name','type','for_process'];
    public static function types(){
        return ['process','insurance','finance'];
    }
    public static function process(){
        return ['surety_bond','guarantee_bank'];
    }
}
