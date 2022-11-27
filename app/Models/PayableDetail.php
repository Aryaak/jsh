<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PayableDetail extends Model
{
    use HasFactory;
    public $fillable = ['nominal','payable_id','surety_bond_id','guarantee_bank_id'];
    public $guarded = [];
    public function payable(){
        return $this->belongsTo(Payable::class);
    }
}
