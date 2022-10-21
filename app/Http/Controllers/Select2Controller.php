<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Select2;

class Select2Controller extends Controller
{
    public function regional(Request $request){
        return response()->json(Select2::regional($request->search ?? ''));
    }

    public function branch(Request $request){
        return response()->json(Select2::branch($request->search ?? ''));
    }

    public function bank(Request $request){
        return response()->json(Select2::bank($request->search ?? ''));
    }
}
