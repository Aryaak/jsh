<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SuretyBondStatus extends Model
{
    use HasFactory;

    public $fillable = ['type','surety_bond_id','status_id'];
    public static function types(){
        return Status::types();
    }
}
