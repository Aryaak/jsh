<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Scoring;
use App\Models\GuaranteeBank;
use Illuminate\Http\Request;

class GuaranteeBankController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = GuaranteeBank::with('last_status','last_status.status');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('product.guarantee-banks',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            GuaranteeBank::buat($request->all());
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

    public function show(GuaranteeBank $bankGaransi)
    {
        $bankGaransi->principal;
        $bankGaransi->obligee;
        $bankGaransi->agent;
        $bankGaransi->bank;
        $bankGaransi->insurance_type;
        $bankGaransi->statuses;
        $bankGaransi->scorings;
        return response()->json($this->showResponse($bankGaransi->toArray()));
    }

    public function edit(GuaranteeBank $bankGaransi)
    {
    }

    public function update(Request $request, GuaranteeBank $bankGaransi)
    {
        try {
            DB::beginTransaction();
            $bankGaransi->ubah($request->all());
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

    public function destroy(GuaranteeBank $bankGaransi)
    {
        try {
            DB::beginTransaction();
            $bankGaransi->hapus();
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
