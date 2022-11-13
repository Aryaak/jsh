<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuaranteeBank;

class GuaranteeBankReport extends Controller
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
}
