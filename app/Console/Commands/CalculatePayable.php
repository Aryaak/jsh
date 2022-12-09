<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SuretyBond;
use App\Models\GuaranteeBank;
use App\Models\Branch;
use App\Models\Payable;
use Log;

class CalculatePayable extends Command
{
    protected $signature = 'payable:calculate';

    protected $description = 'Menghitung payable bulan sebelumnya';

    public function handle()
    {
        try {
            $lastMonth = date('m',strtotime('-1 month'));
            // $lastMonth = date('m');
            $params = [];
            Log::info("Proses perhitungan payable periode ".$lastMonth.' - '.date('Y')." dimulai...");
            foreach (Branch::where('is_regional',false)->get() as $branch) {
                Log::info("Menghitung payable cabang $branch->name ...");
                $details = [];
                $payableTotal = 0;
                foreach (SuretyBond::where('branch_id',$branch->id)->whereMonth('created_at',$lastMonth)->whereYear('created_at',date('Y'))->get() as $data) {
                    $payableTotal += $data->office_net_total;
                    $details[] = [
                        'nominal' => $data->office_net_total,
                        'surety_bond_id' => $data->id,
                        'guarantee_bank_id' => null
                    ];
                }
                foreach (GuaranteeBank::where('branch_id',$branch->id)->whereMonth('created_at',$lastMonth)->whereYear('created_at',date('Y'))->get() as $data) {
                    $payableTotal += $data->office_net_total;
                    $details[] = [
                        'nominal' => $data->office_net_total,
                        'surety_bond_id' => null,
                        'guarantee_bank_id' => $data->id
                    ];
                }
                $params[] = (object)[
                    'payable' => [
                        'month' => $lastMonth,
                        'year' => date('Y'),
                        'payable_total' => $payableTotal,
                        'paid_total' => 0,
                        'unpaid_total' => $payableTotal,
                        'is_paid_off' => false,
                        'branch_id' => $branch->id,
                        'branch_name' => $branch->name,
                    ],
                    'details' => $details
                ];
                Log::info("Selesai...");
            }
            foreach ($params as $param) {
                Log::info("Membuat payable cabang ".$param->payable['branch_name']);
                $doesntExist = Payable::where('month',$param->payable['month'])->where('year',$param->payable['year'])->where('branch_id',$param->payable['branch_id'])->doesntExist();
                if($doesntExist){
                    $payable = Payable::create($param->payable);
                    if(isset($param->details)){
                        $payable->details()->createMany($param->details);
                    }
                    Log::info("Selesai...");
                }else{
                    Log::info("Payable periode ".$param->payable['month']." ".$param->payable['year']." cabang ".$param->payable['branch_name']." sudah terbuat. Melanjutkan ke cabang selanjutnya...");
                }
            }
            Log::info("Proses perhitungan payable periode ".$lastMonth.' - '.date('Y')." berhasil...");
        } catch (Exeption $e) {
            Log::info("Terjadi kesalahan tak terduga. Seluruh proses dihentikan. Error Message: ".$e->getMessage());
        }
    }
}
