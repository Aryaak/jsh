<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Helpers\Sirius;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payable extends Model
{
    use HasFactory;

    public $fillable = ['payable_total','paid_total','unpaid_total','is_paid_off','payment_id'];
    protected $appends = ['payable_total_converted', 'paid_total_converted','unpaid_total_converted'];

    public function payableTotalConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->payable_total, 2));
    }
    public function paidTotalConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->paid_total, 2));
    }
    public function unpaidTotalConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->unpaid_total, 2));
    }
    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
