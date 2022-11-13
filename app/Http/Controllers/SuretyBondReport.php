<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuretyBond;

class SuretyBondReport extends Controller
{
    public function income(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('income',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('income',$request->all())));
            }
        }
        return view('report.surety-bond.income');
    }
    public function expense(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('expense',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('expense',$request->all())));
            }
        }
        return view('report.surety-bond.expense');
    }
    public function finance(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('finance',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('finance',$request->all())));
            }
        }
        return view('report.surety-bond.finance');
    }
    public function product(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table('product',$request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart('product',$request->all())));
            }
        }
        return view('report.surety-bond.product');
    }
}
