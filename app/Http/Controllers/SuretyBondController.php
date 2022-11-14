<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\SuretyBond;
use App\Models\Scoring;
use Illuminate\Http\Request;
use App\Http\Requests\SuretyBondRequest;

class SuretyBondController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = SuretyBond::with('insurance_status','insurance_status.status');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('product.surety-bonds',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(SuretyBondRequest $request)
    {
        try {
            DB::beginTransaction();
            SuretyBond::buat($request->validated());
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
        foreach ($suretyBond->statuses as $statuses) {
            $statuses->status;
        }
        return response()->json($this->showResponse($suretyBond->toArray()));
    }

    public function edit(SuretyBond $suretyBond)
    {
    }

    public function update(SuretyBondRequest $request, SuretyBond $suretyBond)
    {
        try {
            DB::beginTransaction();
            $suretyBond->ubah($request->validated());
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
