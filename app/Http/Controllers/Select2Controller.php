<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Select2;
use App\Models\GuaranteeBank;

class Select2Controller extends Controller
{
    public function regional(Request $request){
        return response()->json(Select2::regional($request->search));
    }

    public function branch(Request $request){
        return response()->json(Select2::branch($request->search));
    }

    public function bank(Request $request){
        return response()->json(Select2::bank($request->search));
    }

    public function province(Request $request){
        return response()->json(Select2::province($request->search));
    }

    public function city(Request $request){
        return response()->json(Select2::city($request->search,$request->province_id));
    }

    public function agent(Request $request){
        return response()->json(Select2::agent($request->search));
    }

    public function insurance(Request $request){
        return response()->json(Select2::insurance($request->search));
    }

    public function insuranceType(Request $request){
        return response()->json(Select2::insuranceType($request->search));
    }

    public function obligee(Request $request){
        return response()->json(Select2::obligee($request->search));
    }

    public function principal(Request $request){
        return response()->json(Select2::principal($request->search));
    }

    public function suretyTemplate(Request $request){
        return response()->json(Select2::suretyTemplate($request->search));
    }

    public function bankTemplate(Request $request, $id){
        return response()->json(Select2::bankTemplate($request->search, $id));
    }
}
