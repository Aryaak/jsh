<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceTypeRequest;
use DB;
use Exception;
use App\Models\InsuranceType;
use Illuminate\Http\Request;

class InsuranceTypeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = InsuranceType::all();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.insurance-types');
    }

    public function create()
    {
    }

    public function store(InsuranceTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            InsuranceType::buat($request->validated());
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

    public function show(InsuranceType $jenisJaminan)
    {
        $insuranceType = $jenisJaminan;
        return response()->json($this->showResponse($insuranceType->toArray()));
    }

    public function edit(InsuranceType $insuranceType)
    {
    }

    public function update(Request $request, InsuranceType $jenisJaminan)
    {
        $insuranceType = $jenisJaminan;
        try {
            DB::beginTransaction();
            $insuranceType->ubah($request->all());
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

    public function destroy(InsuranceType $jenisJaminan)
    {
        $insuranceType = $jenisJaminan;
        try {
            DB::beginTransaction();
            $insuranceType->hapus();
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
