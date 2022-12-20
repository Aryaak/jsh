<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\SuretyBond;
use App\Models\GuaranteeBank;
use Illuminate\Http\Request;
use DB;

class OtherReportController
{
    public function profit(Request $request){
        if($request->ajax()){
            $toInsurance = DB::table('payments as pm')->join('insurances AS i','i.id','pm.insurance_id')
            ->where('pm.type','regional_to_insurance')->where('pm.regional_id',auth()->id())->selectRaw("
                CONCAT('Setoran ke ',i.name) AS title,pm.paid_at,0 AS debit,pm.total_bill AS credit
            ");
            $customExpense = DB::table('expenses as e')->where('e.regional_id',auth()->id())
            ->selectRaw("e.title,e.transaction_date AS paid_at,0 AS debit,e.nominal AS 'credit'");

            $profits = DB::table('instalments as i')->join('branches as b','b.id','i.branch_id')
            ->selectRaw("CONCAT('Setoran Cabang ',b.name) AS title, i.paid_at,i.nominal AS debit,0 AS credit")
            ->where('i.regional_id',auth()->id())
            ->unionAll($toInsurance)
            ->unionAll($customExpense)
            ->get();
            return datatables()->of($profits)
            ->addIndexColumn()
            ->toJson();
        }
        return view('report.other.profit');
    }
}
