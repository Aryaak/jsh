<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\SuretyBond;
use App\Models\Scoring;
use Illuminate\Http\Request;

class SuretyBondController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = SuretyBond::with('last_status','last_status.status');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        // dd($scorings);
        return view('product.surety-bonds',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            SuretyBond::buat($request->all());
            $http_code = 200;
            $response = $this->storeResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function show(SuretyBond $suretyBond)
    {
        $suretyBond->principal;
        $suretyBond->obligee;
        $suretyBond->agent;
        $suretyBond->insurance;
        $suretyBond->insurance_type;
        $suretyBond->statuses;
        $suretyBond->scorings;
        return response()->json($this->showResponse($suretyBond->toArray()));
    }

    public function edit(SuretyBond $suretyBond)
    {
    }

    public function update(Request $request, SuretyBond $suretyBond)
    {
        try {
            DB::beginTransaction();
            $suretyBond->ubah($request->all());
            $http_code = 200;
            $response = $this->updateResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function destroy(SuretyBond $suretyBond)
    {
        try {
            DB::beginTransaction();
            $suretyBond->hapus();
            $http_code = 200;
            $response = $this->destroyResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
