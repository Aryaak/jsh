<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuretyBond;
use Exception;

class ReportController extends Controller
{
    public function incomeSB(Request $request){
        if($request->ajax()){
            if($request->request_for == 'datatable'){
                $data = SuretyBond::table($request->params);
                return datatables()->of($data)
                ->addIndexColumn()
                ->toJson();
            }else if($request->request_for == 'chart'){
                return response()->json($this->showResponse(SuretyBond::chart($request->all())));
            }
        }
        return view('report.income');
    }
}
