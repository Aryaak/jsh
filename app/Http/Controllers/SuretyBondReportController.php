<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use Illuminate\Http\Request;
use App\Models\SuretyBond;

class SuretyBondReportController extends Controller
{
    public function income(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('income',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('income',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('date', fn($d) => Sirius::toLongDateTime($d->date))
                ->editColumn('nominal', fn($d) => Sirius::toRupiah($d->nominal))
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('income',$request->all())));
            }
        }
        return view('report.surety-bond.income');
    }
    public function expense(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('expense',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('expense',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('date', fn($d) => Sirius::toLongDateTime($d->date))
                ->editColumn('nominal', fn($d) => Sirius::toRupiah($d->nominal))
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('expense',$request->all())));
            }
        }
        return view('report.surety-bond.expense');
    }
    public function finance(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('finance',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('finance',$request->params);
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
                ->editColumn('status', 'datatables.status-surety-bond')
                ->rawColumns(['status'])
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('finance',$request->all())));
            }else if($request->request_for == 'summary'){
                return response()->json($this->showResponse(SuretyBond::summary('finance',$request->all())));
            }
        }
        return view('report.surety-bond.finance');
    }
    public function production(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('production',$request->params);
            return $data;
        }
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('production',$request->params);
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
                ->editColumn('status', 'datatables.status-surety-bond')
                ->rawColumns(['status'])
                ->toJson();
            }
            else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('production',$request->all())));
            }
        }
        return view('report.surety-bond.production');
    }
    public function remain(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('remain',$request->params);
            return $data;
        }
        if($request->ajax()){
            $data = SuretyBond::table('remain',$request->params);
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
            ->editColumn('status', 'datatables.status-surety-bond')
            ->rawColumns(['status'])
            ->toJson();
        }
        return view('report.surety-bond.remain');
    }
    public function profit(Request $request){
        if (isset($request->print)) {
            $data = SuretyBond::table('profit',$request->params);
            return $data;
        }
        if($request->ajax()){
            $data = SuretyBond::table('profit',$request->params);
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('debit', fn($d) => number_format($d->debit, thousands_separator: '.'))
            ->editColumn('credit', fn($d) => number_format($d->credit, thousands_separator: '.'))
            ->toJson();
        }
        return view('report.surety-bond.profit');
    }
}
