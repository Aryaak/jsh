<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use DB;
use Exception;
use App\Models\AgentRate;
use Illuminate\Http\Request;
use App\Http\Requests\AgentRateRequest;

class AgentRateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = AgentRate::with('agent','insurance','insurance_type','bank')
            ->when($request->is_bg == 1, function ($query){
                return $query->has('bank');
            })->when($request->is_bg == 0, function ($query){
                return $query->has('bank',0);
            });
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('min_value', fn($rate) => Sirius::toRupiah($rate->min_value))
            ->editColumn('polish_cost', fn($rate) => Sirius::toRupiah($rate->polish_cost))
            ->editColumn('stamp_cost', fn($rate) => Sirius::toRupiah($rate->stamp_cost))
            ->editColumn('rate_value', fn($rate) => str_replace('.', ',', $rate->rate_value))
            ->editColumn('action', 'datatables.actions-show-delete-sb-bg')
            ->toJson();
        }
        return view('master.agent-rates');
    }

    public function create()
    {
    }

    public function store(AgentRateRequest $request)
    {
        try {
            DB::beginTransaction();
            AgentRate::buat($request->validated());
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

    public function show(AgentRate $rateAgen)
    {
        $rateAgen->agent;
        $rateAgen->insurance;
        $rateAgen->insurance_type;
        $rateAgen->bank;
        return response()->json($this->showResponse($rateAgen->toArray()));
    }

    public function edit(AgentRate $rateAgen)
    {
    }

    public function update(AgentRateRequest $request, AgentRate $rateAgen)
    {
        try {
            DB::beginTransaction();
            $rateAgen->ubah($request->validated());
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

    public function destroy(AgentRate $rateAgen)
    {
        try {
            DB::beginTransaction();
            $rateAgen->hapus();
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
