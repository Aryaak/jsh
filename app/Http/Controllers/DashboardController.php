<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\SuretyBond;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sb_lunas = 0;
        $sb_non_lunas = 0;
        $agen_count = Agent::all()->count();
        $sbs = SuretyBond::all();
        foreach($sbs as $sb){
            if($sb->finance_status->status_id == 13){
                $sb_non_lunas++;
            }else if($sb->finance_status->status_id == 12){
                $sb_lunas++;
            }
        }
        return view('master.dashboard', [
            'agen' => $agen_count,
            'lunas' => $sb_lunas,
            'non_lunas' => $sb_non_lunas,
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(int $id)
    {
    }

    public function edit(int $id)
    {
    }

    public function update(Request $request, int $id)
    {
    }

    public function destroy(int $id)
    {
    }
}
