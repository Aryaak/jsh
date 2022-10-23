<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use App\Models\InsuranceRate;
use App\Http\Requests\InsuranceRateRequest;

class InsuranceRateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = InsuranceRate::with('insurance','insurance_type');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.insurance-rates');
    }

    public function create()
    {
    }

    public function store(InsuranceRateRequest $request)
    {
        try {
            DB::beginTransaction();
            InsuranceRate::buat($request->validated());
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

    public function show(InsuranceRate $insuranceRate)
    {
        $insuranceRate->insurance;
        $insuranceRate->insurance_type;
        return response()->json($this->showResponse($insuranceRate->toArray()));
    }

    public function edit(InsuranceRate $insuranceRate)
    {
    }

    public function update(InsuranceRateRequest $request, InsuranceRate $insuranceRate)
    {
        try {
            DB::beginTransaction();
            $insuranceRate->ubah($request->validated());
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

    public function destroy(InsuranceRate $insuranceRate)
    {
        try {
            DB::beginTransaction();
            $insuranceRate->hapus();
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
