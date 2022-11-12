<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuretyBond;

class ReportController
{
    public function incomeSB(Request $request){
        if($request->ajax()){
            $data = SuretyBond::report($request->all());
            return datatables()->of($data)
            ->addIndexColumn()
            ->toJson();
        }
        return view('report.income');
    }
}
