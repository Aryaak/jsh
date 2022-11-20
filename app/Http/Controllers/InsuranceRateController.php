<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
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
            $data = InsuranceRate::with('insurance','insurance_type')->select('insurance_rates.*')->orderBy('created_at','desc');
            // $data = DB::table('insurance_rates as ir')
            // ->join('insurances as i','i.id','ir.insurance_id')
            // ->join('insurance_types as it','it.id','ir.insurance_type_id')
            // ->select('ir.*','i.name','it.name as insurance_type_name')->orderBy('ir.created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('min_value', fn($rate) => Sirius::toRupiah($rate->min_value))
            ->editColumn('polish_cost', fn($rate) => Sirius::toRupiah($rate->polish_cost))
            ->editColumn('stamp_cost', fn($rate) => Sirius::toRupiah($rate->stamp_cost))
            ->editColumn('rate_value', fn($rate) => str_replace('.', ',', $rate->rate_value))
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

    public function show(InsuranceRate $rateAsuransi)
    {
        $rateAsuransi->insurance;
        $rateAsuransi->insurance_type;
        return response()->json($this->showResponse($rateAsuransi->toArray()));
    }

    public function edit(InsuranceRate $rateAsuransi)
    {
    }

    public function update(InsuranceRateRequest $request, InsuranceRate $rateAsuransi)
    {
        try {
            DB::beginTransaction();
            $rateAsuransi->ubah($request->validated());
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

    public function destroy(InsuranceRate $rateAsuransi)
    {
        try {
            DB::beginTransaction();
            $rateAsuransi->hapus();
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
