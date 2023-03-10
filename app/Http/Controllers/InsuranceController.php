<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Insurance;
use App\Http\Requests\InsuranceRequest;
use App\Models\InsuranceType;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Insurance::orderBy('created_at','desc')->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.insurances');

    }

    public function create()
    {
    }

    public function store(InsuranceRequest $request)
    {
        try {
            DB::beginTransaction();
            Insurance::buat($request->validated());
            DB::commit();
            $http_code = 200;
            $response = $this->storeResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function show(Insurance $asuransi)
    {
        return response()->json($this->showResponse($asuransi->toArray()));
    }

    public function edit(Insurance $asuransi)
    {
    }

    public function update(Request $request, Insurance $asuransi)
    {
        try {
            DB::beginTransaction();
            $asuransi->ubah($request->all());
            DB::commit();
            $http_code = 200;
            $response = $this->storeResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function destroy(Insurance $asuransi)
    {
        try {
            DB::beginTransaction();
            $asuransi->hapus();
            DB::commit();
            $http_code = 200;
            $response = $this->destroyResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
