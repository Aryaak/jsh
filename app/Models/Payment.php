<?php

namespace App\Models;

use App\Helpers\Sirius;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuretyBond;
use App\Models\Payable;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    use HasFactory;

    public $fillable = ['total_bill','paid_bill','unpaid_bill','paid_at','month','year','desc','type','agent_id','insurance_id','principal_id','branch_id','regional_id'];

    protected $appends = ['paid_at_converted', 'total_bill_converted','paid_bill_converted','unpaid_bill_converted'];

    // Accessors

    public function paidAtConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toLongDate($this->paid_at));
    }
    public function totalBillConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->total_bill, 2));
    }
    public function paidBillConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->paid_bill, 2));
    }
    public function unpaidBillConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->unpaid_bill, 2));
    }

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
        if($type == 'branch_to_regional'){
            if(self::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('branch_id',$args->branchId)->exists()){
                throw new Exception("Pembayaran pada periode ini sudah dilakukan",422);
            }

            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('branch_id',$args->branchId)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => floatval($item->office_net_total)
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = (int)$args->nominal;
            $unpaidBill = $totalBill - $paidBill;
        }else if($type == 'regional_to_insurance'){
            if(self::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->exists()){
                throw new Exception("Pembayaran pada periode ini sudah dilakukan",422);
            }
            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('insurance_id',$args->insuranceId)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => floatval($item->insurance_net_total)
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = $totalBill;
        }else if($type == 'branch_to_agent'){
            if(self::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('agent_id',$args->agentId)->exists()){
                throw new Exception("Pembayaran pada periode ini sudah dilakukan",422);
            }
            $details = array_values(SuretyBond::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('agent_id',$args->agentId)->get()->map(function ($item){
                return [
                    'surety_bond_id' => $item->id,
                    'guarantee_bank_id' => null,
                    'total' => floatval($item->total_charge) - floatval($item->office_net_total)
                ];
            })->all());
            $totalBill = array_sum(array_column($details,'total'));
            $paidBill = $totalBill;
        }

        return (object)[
            'payment' => [
                'paid_at' => $args->datetime ?? null,
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
    public static function calculatePayable($params = []){
        $params = (object)$params;
        $payables = self::where('unpaid_bill','<>',0)->where('branch_id',$params->branchId)->whereHas('payable',function($query){
            $query->where('is_paid_off',false);
        })->get();
        return $payables->sum('unpaid_total');
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        // dd($request,$params);
        $payment = self::create($request->payment);
        if(isset($request->payment['branch_id']) && isset($request->payment['regional_id'])){
            $paidTotal = $payment->paid_bill;
            // $paidTotal = 36500000;
            // $ori = $paidTotal;
            $payables = Payable::where('is_paid_off',false)->whereHas('payment',function($query) use ($request){
                $query->where('branch_id',$request->payment['branch_id']);
            })->orderBy('id','asc')->get();
            // $payables = Payable::where('is_paid_off',false)->orderBy('id','asc')->get();
            $payablePaid = [];
            foreach ($payables as $payable) {
                if($paidTotal > 0){
                    $checkPaid = $paidTotal;
                    if($checkPaid >= $payable->unpaid_total){ $checkPaid = $payable->unpaid_total; }
                    $unpaidTotal = $payable->unpaid_total - $checkPaid;
                    $payablePaid[$payable->id] = (object)[
                        'payable' => [
                            'paid_total' => $payable->paid_total + $checkPaid,
                            'unpaid_total' => $unpaidTotal,
                            'is_paid_off' => $unpaidTotal <= 0 ? true : false,
                            'paid' => $checkPaid
                        ],
                        'payable_payment' => [
                            'nominal' => $checkPaid,
                            'payment_id' => $payment->id,
                            'payable_id' => $payable->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    ];
                    $paidTotal -= $checkPaid;
                }
            }
            if(!empty($payablePaid)){
                foreach ($payablePaid as $id => $value) {
                    Payable::find($id)->update($value->payable);
                    DB::table('payable_payment')->insert($value->payable_payment);
                }
            }
            // dd($payablePaid,$ori,$paidTotal);

            //buat hutang baru
            if($payment->unpaid_bill > 0){
                $payment->payable()->create([
                    'payable_total' => $payment->unpaid_bill,
                    'paid_total' => 0,
                    'unpaid_total' => $payment->unpaid_bill,
                    'is_paid_off' => 0
                ]);
            }
        }
        // dd('note');
        $payment->details()->createMany($request->details);
        return $payment;
    }
    public function hapus(): bool{
        $this->details()->delete();
        return $this->delete();
    }
}
