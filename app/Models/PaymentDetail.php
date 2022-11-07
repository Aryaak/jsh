<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    public $fillable = ['total','payment_id','surety_bond_id','guarantee_bank_id'];
    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
