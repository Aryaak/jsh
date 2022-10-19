<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Branch;
use Illuminate\Http\Request;

class AgentController
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = [
                'agents' => Agent::all(),
                'branches' => Branch::all(),
            ];
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

    public function store(Request $request)
    {
    }

    public function show(Agent $agent)
    {
    }

    public function edit(Agent $agent)
    {
    }

    public function update(Request $request, Agent $agent)
    {
    }

    public function destroy(Agent $agent)
    {
    }
}
