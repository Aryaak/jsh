<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuaranteeBank;

class GuaranteeBankReportController extends Controller
{
    public function income(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('income',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
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
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('finance',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('finance',$request->all())));
            }
        }
        return view('report.guarantee-bank.finance');
    }
    public function product(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = GuaranteeBank::table('product',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(GuaranteeBank::chart('product',$request->all())));
            }
        }
        return view('report.guarantee-bank.product');
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
            ->editColumn('insurance_value', fn($d) => number_format($d->insurance_value, 2, ',', '.'))
            ->editColumn('start_date', fn($d) => date('d/m/y', strtotime($d->start_date)))
            ->editColumn('end_date', fn($d) => date('d/m/y', strtotime($d->end_date)))
            ->editColumn('office_net', fn($d) => number_format($d->office_net, 2, ',', '.'))
            ->editColumn('admin_charge', fn($d) => number_format($d->admin_charge, 2, ',', '.'))
            ->editColumn('office_total', fn($d) => number_format($d->office_total, 2, ',', '.'))
            ->editColumn('service_charge', fn($d) => number_format($d->service_charge, 2, ',', '.'))
            ->editColumn('receipt_total', fn($d) => number_format($d->receipt_total, 2, ',', '.'))
            ->editColumn('total_charge', fn($d) => number_format($d->total_charge, 2, ',', '.'))
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
