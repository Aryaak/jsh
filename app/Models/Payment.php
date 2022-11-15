<?php

namespace App\Models;

use App\Helpers\Sirius;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuretyBond;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    use HasFactory;

    public $fillable = ['total_bill','paid_bill','unpaid_bill','paid_at','month','year','type','agent_id','insurance_id','principal_id','branch_id','regional_id'];

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

    // Relations
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
        if($type == 'principal_to_branch'){
            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => $item->total_charge
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = $totalBill;
        }else if($type == 'branch_to_regional'){

        }else if($type == 'regional_to_insurance'){
            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => $item->insurance_total_net
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = $totalBill;
        }else if($type == 'branch_to_agent'){
            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('agent_id',$args->agentId)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => $item->total_charge - $item->office_total_net
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = $totalBill;
        }

        return (object)[
            'payment' => [
                'paid_at' => $args->paidAt ?? null,
                'year' => $args->year,
                'month' => $args->month,
                'total_bill' => $totalBill,
                'paid_bill' => $paidBill,
                'unpaid_bill' => $unpaidBill,
                'type' => $type,
                'desc' => $args->desc,
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
        $payment = self::create($request->payment);
        $payment->details()->createMany($request->details);
        return $payment;
    }
    public function hapus(): bool{
        $this->details()->delete();
        return $this->delete();
    }
}
