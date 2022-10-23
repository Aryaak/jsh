<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\AgentRate;
use Illuminate\Http\Request;

class AgentRateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = AgentRate::with('agent','insurance','insurance_type');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.agent-rates');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            AgentRate::buat($request->all());
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

    public function show(AgentRate $agentRate)
    {
        $agentRate->agent;
        $agentRate->insurance;
        $agentRate->insurance_type;
        return response()->json($this->showResponse($agentRate->toArray()));
    }

    public function edit(AgentRate $agentRate)
    {
    }

    public function update(Request $request, AgentRate $agentRate)
    {
        try {
            DB::beginTransaction();
            $agentRate->ubah($request->all());
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

    public function destroy(AgentRate $agentRate)
    {
        try {
            DB::beginTransaction();
            $agentRate->hapus();
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
