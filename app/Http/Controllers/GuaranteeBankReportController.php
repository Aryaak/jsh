<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use Illuminate\Http\Request;
use App\Models\GuaranteeBank;

class GuaranteeBankReportController extends Controller
{
    public function income(Request $request){
        if (isset($request->print)) {
            $data = GuaranteeBank::table('income',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('income',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('date', fn($d) => Sirius::toLongDateTime($d->date))
                ->editColumn('nominal', fn($d) => Sirius::toRupiah($d->nominal))
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('income',$request->all())));
            }
        }
        return view('report.guarantee-bank.income');
    }
    public function expense(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('expense',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('expense',$request->all())));
            }
        }
        return view('report.guarantee-bank.expense');
    }
    public function finance(Request $request){
        if (isset($request->print)) {
            $data = GuaranteeBank::table('finance',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('finance',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('paid_date', fn($d) => date('d/m/y', strtotime($d->paid_date)))
                ->editColumn('insurance_value', fn($d) => number_format($d->insurance_value, thousands_separator: '.'))
                ->editColumn('start_date', fn($d) => date('d/m/y', strtotime($d->start_date)))
                ->editColumn('end_date', fn($d) => date('d/m/y', strtotime($d->end_date)))
                ->editColumn('insurance_net', fn($d) => number_format($d->insurance_net, thousands_separator: '.'))
                ->editColumn('insurance_polish_cost', fn($d) => number_format($d->insurance_polish_cost, thousands_separator: '.'))
                ->editColumn('insurance_stamp_cost', fn($d) => number_format($d->insurance_stamp_cost, thousands_separator: '.'))
                ->editColumn('insurance_nett_total', fn($d) => number_format($d->insurance_nett_total, thousands_separator: '.'))
                ->editColumn('office_net', fn($d) => number_format($d->office_net, thousands_separator: '.'))
                ->editColumn('admin_charge', fn($d) => number_format($d->admin_charge, thousands_separator: '.'))
                ->editColumn('office_total', fn($d) => number_format($d->office_total, thousands_separator: '.'))
                ->editColumn('profit', fn($d) => number_format($d->profit, thousands_separator: '.'))
                ->editColumn('status', 'datatables.guarantee-bank')
                ->rawColumns(['status'])
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('finance',$request->all())));
            }else if($request->request_for == 'summary'){
                return response()->json($this->showResponse(GuaranteeBank::summary('finance',$request->all())));
            }
        }
        return view('report.guarantee-bank.finance');
    }
    public function production(Request $request){
        if (isset($request->print)) {
            $data = GuaranteeBank::table('production',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('production',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('insurance_value', fn($d) => number_format($d->insurance_value, thousands_separator: '.'))
                ->editColumn('start_date', fn($d) => date('d/m/y', strtotime($d->start_date)))
                ->editColumn('end_date', fn($d) => date('d/m/y', strtotime($d->end_date)))
                ->editColumn('insurance_net', fn($d) => number_format($d->insurance_net, thousands_separator: '.'))
                ->editColumn('insurance_polish_cost', fn($d) => number_format($d->insurance_polish_cost, thousands_separator: '.'))
                ->editColumn('insurance_stamp_cost', fn($d) => number_format($d->insurance_stamp_cost, thousands_separator: '.'))
                ->editColumn('insurance_nett_total', fn($d) => number_format($d->insurance_nett_total, thousands_separator: '.'))
                ->editColumn('office_net', fn($d) => number_format($d->office_net, thousands_separator: '.'))
                ->editColumn('admin_charge', fn($d) => number_format($d->admin_charge, thousands_separator: '.'))
                ->editColumn('office_total', fn($d) => number_format($d->office_total, thousands_separator: '.'))
                ->editColumn('profit', fn($d) => number_format($d->profit, thousands_separator: '.'))
                ->editColumn('status', 'datatables.status-guarantee-bank')
                ->rawColumns(['status'])
                ->toJson();
            }
            else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('production',$request->all())));
            }
        }
        return view('report.guarantee-bank.production');
    }
    public function remain(Request $request){
        if (isset($request->print)) {
            $data = GuaranteeBank::table('remain',$request->params);
            return $data;
        }
        if($request->ajax()){
            $data = GuaranteeBank::table('remain',$request->params);
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($d) => number_format($d->insurance_value, thousands_separator: '.'))
            ->editColumn('start_date', fn($d) => date('d/m/y', strtotime($d->start_date)))
            ->editColumn('end_date', fn($d) => date('d/m/y', strtotime($d->end_date)))
            ->editColumn('office_net', fn($d) => number_format($d->office_net, thousands_separator: '.'))
            ->editColumn('admin_charge', fn($d) => number_format($d->admin_charge, thousands_separator: '.'))
            ->editColumn('office_total', fn($d) => number_format($d->office_total, thousands_separator: '.'))
            ->editColumn('service_charge', fn($d) => number_format($d->service_charge, thousands_separator: '.'))
            ->editColumn('receipt_total', fn($d) => number_format($d->receipt_total, thousands_separator: '.'))
            ->editColumn('total_charge', fn($d) => number_format($d->total_charge, thousands_separator: '.'))
            ->editColumn('status', 'datatables.status-guarantee-bank')
            ->rawColumns(['status'])
            ->toJson();
        }
        return view('report.guarantee-bank.remain');
    }
    public function profit(Request $request){
        if($request->ajax()){
            $data = GuaranteeBank::table('profit',$request->params);
            return datatables()->of($data)
            ->addIndexColumn()
            ->toJson();
        }
        return view('report.guarantee-bank.profit');
    }
}
