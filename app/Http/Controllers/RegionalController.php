<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class RegionalController
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Branch::where('is_regional',true);
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.regionals');
    }
}
