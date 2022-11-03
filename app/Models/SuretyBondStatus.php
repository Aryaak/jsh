<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SuretyBondStatus extends Model
{
    use HasFactory;

    public $fillable = ['type','surety_bond_id','status_id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
    ];
    public function surety_bond(){
        return $this->belongsTo(SuretyBond::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public static function types(){
        return Status::types();
    }

}
