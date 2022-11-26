<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Instalment extends Model
{
    use HasFactory;
    public $fillable = ['nominal','paid_at','desc','branch_id'];
    public $guarded = [];
    public function payables(){
        return $this->belongsToMany(Payable::class)->withPivot('nominal')->withTimestamps();
    }
    private static function fetch(object $args){
        $instalment = [];
        $payables = Payable::whereBranchId($args->branchId)->where('is_paid_off',false)->orderBy('id','asc')->get();
        $nominal = $args->nominal;
        $payablePaid = [];
        $instalmentPayment = [];
        foreach ($payables as $payable) {
            if($nominal > 0){
                $checkPaid = $nominal;
                if($checkPaid >= $payable->unpaid_total){ $checkPaid = $payable->unpaid_total; }
                $unpaidTotal = $payable->unpaid_total - $checkPaid;
                $payablePaid[$payable->id] = [
                    'paid_total' => $payable->paid_total + $checkPaid,
                    'unpaid_total' => $unpaidTotal,
                    'is_paid_off' => $unpaidTotal <= 0 ? true : false,
                ];
                $instalmentPayment[$payable->id] = [ 'nominal' => $checkPaid ];
                $nominal -= $checkPaid;
            }
        }
        return (object)[
            'instalment' => [
                'nominal' => $args->nominal,
                'paid_at' => $args->datetime,
                'desc' => $args->desc,
                'branch_id' => $args->branchId
            ],
            'payables' => $payablePaid,
            'instalment_payable' => $instalmentPayment
        ];
    }
    public static function buat($params): self{
        $request = self::fetch((object)$params);
        $instalment = self::create($request->instalment);
        foreach ($request->payables as $id => $params){
            Payable::findOrFail($id)->update($params);
        }
        $instalment->payables()->sync($request->instalment_payable);
        return $instalment;
    }
    public function hapus(){
        $payableRevert = [];
        foreach ($this->payables as $payable) {
            $nominal = $payable->pivot->nominal;
            $unpaid = $payable->unpaid_total + $nominal;
            $payableRevert[$payable->id] = [
                'paid_total' => $payable->paid_total - $nominal,
                'unpaid_total' => $unpaid,
                'is_paid_off' => $unpaid > 0 ? false : true
            ];
        }
        foreach ($payableRevert as $id => $params){ Payable::findOrFail($id)->update($params); }
        $this->payables()->detach();
        return $this->delete();
    }
}
