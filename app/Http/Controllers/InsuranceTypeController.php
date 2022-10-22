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

    public function show(InsuranceType $insuranceType)
    {
        return response()->json($this->showResponse($insuranceType->toArray()));
    }

    public function edit(InsuranceType $insuranceType)
    {
    }

    public function update(Request $request, InsuranceType $insuranceType)
    {
        try {
            DB::beginTransaction();
            $insuranceType->ubah($request->all());
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

    public function destroy(InsuranceType $insuranceType)
    {
        try {
            DB::beginTransaction();
            $insuranceType->hapus();
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
