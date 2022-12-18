<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Helpers\Sirius;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payable extends Model
{
    use HasFactory;

    public $fillable = ['month','year','payable_total','paid_total','unpaid_total','is_paid_off','branch_id','regional_id'];
    protected $appends = ['payable_total_converted', 'paid_total_converted','unpaid_total_converted'];
    public function instalments(){
        return $this->belongsToMany(Instalment::class)->withPivot('nominal')->withTimestamps();
    }
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
    public function details(){
        return $this->hasMany(PayableDetail::class);
    }
    public static function calculate($params = []){
        $params = (object)$params;
        return self::whereBranchId($params->branchId)->where('is_paid_off',0)->sum('unpaid_total');
    }
    public static function index($params = []){
        $params = (object)$params;
        $payables = self::whereBranchId($params->branchId)->where('is_paid_off',0)->get();
        return [
            'index' => $payables,
            'total' => $payables->sum('unpaid_total')
        ];
    }

}
