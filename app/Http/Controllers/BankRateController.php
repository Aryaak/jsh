<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\BankRate;
use Illuminate\Http\Request;
use App\Http\Requests\BankRateRequest;

class BankRateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = BankRate::with('bank','insurance','insurance_type');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.bank-rates');
    }

    public function create()
    {
    }

    public function store(BankRateRequest $request)
    {
        try {
            DB::beginTransaction();
            BankRate::buat($request->validated());
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

    public function show(BankRate $rateBank)
    {
        $rateBank->bank;
        $rateBank->insurance;
        $rateBank->insurance_type;
        return response()->json($this->showResponse($rateBank->toArray()));
    }

    public function edit(BankRate $rateBank)
    {
    }

    public function update(BankRateRequest $request, BankRate $rateBank)
    {
        try {
            DB::beginTransaction();
            $rateBank->ubah($request->validated());
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

    public function destroy(BankRate $rateBank)
    {
        try {
            DB::beginTransaction();
            $rateBank->hapus();
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
