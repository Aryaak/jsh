<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\SuretyBond;
use App\Models\GuaranteeBank;
use Illuminate\Http\Request;
use DB;
use App\Helpers\Sirius;
class OtherReportController
{
    public function profit(Request $request){
        if (isset($request->print) || $request->ajax()) {
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
        }
        if (isset($request->print)) {
            return $profits;
        }
        if($request->ajax()){
            return datatables()->of($profits)
            ->addIndexColumn()
            ->toJson();
        }
        return view('report.other.profit');
    }

    public function installment(Request $request){
        $payables = DB::table('payables as p')->join('payable_details as pd','p.id','pd.payable_id')
        ->selectRaw("month,year,sum(payable_total) as jumlah_tagihan,(count(pd.surety_bond_id) + count(pd.guarantee_bank_id)) as jumlah_polis")
        ->when(auth()->user()->branch?->is_regional == true && auth()->user()->username != 'root',function($query){
            $query->where('p.regional_id',auth()->id());
        })
        ->when(auth()->user()->branch?->is_regional == false && auth()->user()->username != 'root',function($query){
            $query->where('p.branch_id',auth()->id());
        })
        ->groupBy('month','year')->where('year',date('Y'))
        ->get();
        $instalments = DB::table('instalments')
        ->when(auth()->user()->branch?->is_regional == true && auth()->user()->username != 'root',function($query){
            $query->where('regional_id',auth()->id());
        })
        ->when(auth()->user()->branch?->is_regional == false && auth()->user()->username != 'root',function($query){
            $query->where('branch_id',auth()->id());
        })->whereYear('paid_at',date('Y'))->get();

        $payableMaxRow = count($payables);
        $instalmentMaxRow = count($instalments);
        $maxRow = $payableMaxRow >= $instalmentMaxRow ? $payableMaxRow : $instalmentMaxRow;
        $rows = [];
        for ($i=0; $i < $maxRow; $i++) {
            $rows[] = (object)[
                'tgl_setor' => isset($payables[$i]) ? Sirius::longMonth($payables[$i]->month) : '',
                'jumlah_polis' => isset($payables[$i]) ? $payables[$i]->jumlah_polis : '',
                'jumlah_tagihan' => isset($payables[$i]) ? Sirius::toRupiah($payables[$i]->jumlah_tagihan) : '',
                'tgl_titipan' => isset($instalments[$i]) ? Sirius::toShortDate($instalments[$i]->paid_at) : '',
                'jumlah_titipan' => isset($instalments[$i]) ? Sirius::toRupiah($instalments[$i]->nominal) : '',
                'keterangan' => isset($instalments[$i]) ? $instalments[$i]->desc : '',
            ];
        }
        if (isset($request->print)) {
            return $rows;
        }
        return view('report.other.instalment',compact('rows'));
    }
}
