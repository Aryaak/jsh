<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $fillable = ['total_bill','paid_bill','unpaid_bill','payment_period_id','type'];
    public static function types(){
        return [];
    }
}
