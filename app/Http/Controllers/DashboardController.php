<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\SuretyBond;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $agen_count = Agent::all()->count();
        $sb_paid = DB::table('surety_bond_statuses')->where('status_id','=',13)->count();
        $sb_not_paid = DB::table('surety_bond_statuses')->where('status_id','=',14)->count();
        $data_sb = DB::table('surety_bonds')
                ->where(DB::raw('YEAR(document_expired_at)'), '=', '2023')
                ->select(DB::raw('SUM(profit) as total_profit, MONTH(document_expired_at) as month'))
                ->groupBy(DB::raw('MONTH(document_expired_at)'))->get();
        $data_sb_final = [];
        for($i = 1; $i <= 12; $i++){
            $exist = false;
            for($j = 0; $j < count($data_sb); $j++){
                if($data_sb[$j]->month == $i){
                    $exist = true;
                    array_push($data_sb_final, ['total_profit'=>$data_sb[$j]->total_profit,'month'=>$i]);
                }
            }
            if($exist == false){
                array_push($data_sb_final, ['total_profit'=>0,'month'=>$i]);
            }
        }
        // dd($data_sb_final);
        return view('dashboard', [
            'agen' => $agen_count,
            'lunas' => $sb_paid,
            'non_lunas' => $sb_not_paid,
            'data_sbs' => $data_sb_final,
        ]);
    }
}
