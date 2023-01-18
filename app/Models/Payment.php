<?php

namespace App\Models;

use App\Helpers\Sirius;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuretyBond;
use App\Models\GuaranteeBank;
use App\Models\Payable;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    use HasFactory;

    public $fillable = ['total_bill','paid_at','month','year','desc','type','agent_id','insurance_id','principal_id','branch_id','regional_id'];

    protected $appends = ['paid_at_converted', 'total_bill_converted'];

    // Accessors

    public function paidAtConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toLongDate($this->paid_at));
    }
    public function totalBillConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->total_bill, 2));
    }
    // public function paidBillConverted(): Attribute
    // {
    //     return Attribute::make(get: fn () => Sirius::toRupiah($this->paid_bill, 2));
    // }
    // public function unpaidBillConverted(): Attribute
    // {
    //     return Attribute::make(get: fn () => Sirius::toRupiah($this->unpaid_bill, 2));
    // }

    // Relations
    public function payable(){
        return $this->hasOne(Payable::class);
    }
    public function details(){
        return $this->hasMany(PaymentDetail::class);
    }
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
    public function insurance(){
        return $this->belongsTo(Insurance::class);
    }
    public function principal(){
        return $this->belongsTo(Principal::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function regional(){
        return $this->belongsTo(Branch::class,'regional_id');
    }
    public static function types(){
        return ['principal_to_branch','branch_to_regional'.'regional_to_insurance','branch_to_agent'];
    }
    public static function fetch(object $args): object{
        $totalBill = 0;
        $paidBill = 0;
        $unpaidBill = 0;
        $year = $args->year;
        $month = $args->month;
        $type = $args->type;
        $details = [];
        if($type == 'regional_to_insurance'){
            if(self::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->exists()){
                throw new Exception("Pembayaran pada periode ini sudah dilakukan",422);
            }
            $details = array_merge(
                array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->get()->map(function ($item){
                    $lastInsuranceStatus = $item->insurance_status->status->name;
                    $nominal = 0;
                    if($lastInsuranceStatus == 'terbit'){
                        $nominal = floatval($item->insurance_net_total);
                    }elseif(in_array($lastInsuranceStatus,['batal','revisi','salah cetak'])){
                        $nominal = floatval($item->insurance_polish_cost) + floatval($item->insurance_stamp_cost);
                    }
                    return [
                        'surety_bond_id' => $item->id,
                        'guarantee_bank_id' => null,
                        'nominal' => $nominal
                    ];
                })->all()),
                array_values(GuaranteeBank::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->get()->map(function ($item){
                    $lastInsuranceStatus = $item->insurance_status->status->name;
                    $nominal = 0;
                    if($lastInsuranceStatus == 'terbit'){
                        $nominal = floatval($item->insurance_net_total);
                    }elseif(in_array($lastInsuranceStatus,['batal','revisi','salah cetak'])){
                        $nominal = floatval($item->insurance_polish_cost) + floatval($item->insurance_stamp_cost);
                    }
                    return [
                        'surety_bond_id' => null,
                        'guarantee_bank_id' => $item->id,
                        'nominal' => $nominal
                    ];
                })->all())
            );
            $totalBill = array_sum(array_column($details,'nominal'));
        }else if($type == 'branch_to_agent'){
            if(self::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('branch_id',$args->branchId)->where('agent_id',$args->agentId)->exists()){
                throw new Exception("Pembayaran pada periode ini sudah dilakukan",422);
            }
            $details = array_merge(
                array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('branch_id',$args->branchId)->where('agent_id',$args->agentId)->get()->map(function ($item){
                    $lastInsuranceStatus = $item->insurance_status->status->name;
                    $nominal = 0;
                    if($lastInsuranceStatus == 'terbit'){
                        $nominal = floatval($item->total_charge) - floatval($item->office_net_total);
                    }
                    return [
                        'surety_bond_id' => $item->id,
                        'guarantee_bank_id' => null,
                        'nominal' => $nominal
                    ];
                })->all()),
                array_values(GuaranteeBank::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('branch_id',$args->branchId)->where('agent_id',$args->agentId)->get()->map(function ($item){
                    $lastInsuranceStatus = $item->insurance_status->status->name;
                    $nominal = 0;
                    if($lastInsuranceStatus == 'terbit'){
                        $nominal = floatval($item->total_charge) - floatval($item->office_net_total);
                    }
                    return [
                        'surety_bond_id' => null,
                        'guarantee_bank_id' => $item->id,
                        'nominal' => $nominal
                    ];
                })->all())
            );
            $totalBill = array_sum(array_column($details,'nominal'));
        }else if($type == 'principal_to_branch'){
            $product = null;
            $details = [];
            if(isset($args->suretyBondId)){
                $product = SuretyBond::findOrFail($args->suretyBondId);
            }else if($args->guaranteeBankId){
                $product = GuaranteeBank::findOrFail($args->guaranteeBankId);
            }
            $insuranceLastStatus = $product->insurance_status->status->name;
            $totalBill = 0;
            if(in_array($insuranceLastStatus,['belum terbit','terbit'])){
                $totalBill = $product->total_charge;
            }else{
                $totalBill = $product->office_polish_cost + $product->office_stamp_cost + $product->admin_charge;
            }
            $details[] = [
                'nominal' => $totalBill,
                'surety_bond_id' => $args->suretyBondId ?? null,
                'guarantee_bank_id' => $args->guaranteeBankId ?? null
            ];
        }

        return (object)[
            'payment' => [
                'paid_at' => $args->datetime ?? null,
                'year' => $args->year,
                'month' => $args->month,
                'total_bill' => $totalBill,
                'type' => $type,
                'desc' => $args->desc ?? null,
                'agent_id' => $args->agentId ?? null,
                'insurance_id' => $args->insuranceId ?? null,
                'principal_id' => $args->principalId ?? null,
                'branch_id' => $args->branchId ?? null,
                'regional_id' => $args->regionalId ?? null
            ],
            'details' => $details,
        ];
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        if($request->payment['total_bill'] == 0){
            throw new Exception("Tidak dapat menyimpan data pembayaran dengan Nominal Bayar 0 (nol)!", 422);
        }
        $payment = self::create($request->payment);
        $payment->details()->createMany($request->details);
        return $payment;
    }
    public function hapus(): bool{
        $this->details()->delete();
        return $this->delete();
    }
}
