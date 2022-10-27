<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Agent;
use App\Http\Requests\AgentRequest;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Agent::with('branch');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.agents');
    }

    public function create()
    {
    }

    public function store(AgentRequest $request)
    {
        try {
            DB::beginTransaction();
            $agent = Agent::buat($request->validated());
            BankAccount::buat($request->validated(),$agent->id);
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

    public function show(Agent $agen)
    {
        $agen->branch;
        $agen->bank_accounts->bank;
        return response()->json($this->showResponse($agen->toArray()));
    }

    public function edit(Agent $agen)
    {
    }

    public function update(Request $request, Agent $agen)
    {
        try {
            DB::beginTransaction();
            $agen->ubah($request->all());
            $bankaccount = $agen->bank_accounts;
            $bankaccount->ubah($request->all(), $agen->id);
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

    public function destroy(Agent $agen)
    {
        try {
            DB::beginTransaction();
            $agen->hapus();
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
