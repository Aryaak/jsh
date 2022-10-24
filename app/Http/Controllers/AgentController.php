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
            $agent = array(
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'is_active' => $request->is_active,
                'is_verified' => $request->is_verified,
                'jamsyar_username' => $request->jamsyar_username,
                'jamsyar_password' => $request->jamsyar_password,
                'branch_id' => $request->branch_id,
            );

            $agent_insert_data = Agent::create($agent);
            $bank_account = array(
                'number' => $request->number,
                'name' => $request->name_bank,
                'agent_id' => $agent_insert_data->id,
                'bank_id' => $request->bank_id,
            );
            BankAccount::create($bank_account);

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
        $agent = $agen;
        $agent->branch;
        $agent->bank_accounts->bank;
        // dd($agent);
        return response()->json($this->showResponse($agent->toArray()));
    }

    public function edit(Agent $agen)
    {
    }

    public function update(Request $request, Agent $agen)
    {
        $agent = $agen;
        try {
            $agent_data = array(
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'is_active' => $request->is_active,
                'is_verified' => $request->is_verified,
                'jamsyar_username' => $request->jamsyar_username,
                'jamsyar_password' => $request->jamsyar_password,
                'branch_id' => $request->branch_id,
            );

            Agent::whereId($agent->id)->update($agent_data);

            $bank_account_data = array(
                'number' => $request->number,
                'name' => $request->name_bank,
                'agent_id' => $request->agent_id,
                'bank_id' => $request->bank_id,
            );
            $bank_account = BankAccount::find($request->bank_account_id);
            BankAccount::whereId($bank_account->id)->update($bank_account_data);

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
        $agent = $agen;
        try {
            BankAccount::whereId($agent->bank_accounts->id)->delete();
            Agent::whereId($agent->id)->delete();
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
