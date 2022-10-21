<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Insurance;
use App\Http\Requests\InsuranceRequest;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Insurance::all();
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

    public function show(Insurance $insurance)
    {
        return response()->json($this->showResponse($insurance->toArray()));
    }

    public function edit(Insurance $insurance)
    {
    }

    public function update(Request $request, Insurance $insurance)
    {
        try {
            DB::beginTransaction();
            $insurance->ubah($request->all());
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

    public function destroy(Insurance $insurance)
    {
        try {
            DB::beginTransaction();
            $insurance->hapus();
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
