<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\GuaranteeBank;
use App\Models\Instalment;
use App\Models\Payment;
use App\Models\SuretyBond;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];


        $agen_count = Agent::all()->count();
        $sb_paid = DB::table('surety_bond_statuses')->where('status_id','=',13)->count();
        $sb_not_paid = DB::table('surety_bond_statuses')->where('status_id','=',14)->count();

        // Surety Bonds
        $data_sb = SuretyBond::
                select(DB::raw('SUM(profit) as total_profit, MONTH(created_at) as month, YEAR(created_at) as tahun'))
                ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
                ->limit(12)
                ->get();
        $data_sb_final = [];
        if($data_sb->isEmpty()){
            for($i = 0; $i < 12; $i++){
                $data_sb_final[$i]['total_profit'] = 0;
                $data_sb_final[$i]['month'] = '-';
                $data_sb_final[$i]['bulan'] = 'Tidak ada data';
            }
        }else{
            $idx = 0;
            for($j = $idx; $j < (12-(count($data_sb)+$data_sb[0]->month-1)); $j++){
                $data_sb_final[$j]['total_profit'] = 0;
                $data_sb_final[$j]['month'] = 13+$j-(12-(count($data_sb)+$data_sb[0]->month-1));
                $data_sb_final[$j]['bulan'] = $labels[12+$j-(12-(count($data_sb)+$data_sb[0]->month-1))].' '.$data_sb[0]->tahun-1;
                $idx++;
            }
            $count = 12-(count($data_sb)+$idx);
            for($j = 1; $j < $count+1; $j++){
                $data_sb_final[$idx]['total_profit'] = 0;
                $data_sb_final[$idx]['month'] = $j;
                $data_sb_final[$idx]['bulan'] = $labels[$j-1].' '.$data_sb[0]->tahun;
                $idx++;
            }
            for($i = 0; $i < count($data_sb); $i++){
                $data_sb_final[$idx]['total_profit'] = $data_sb[$i]->total_profit;
                $data_sb_final[$idx]['month'] = $data_sb[$i]->month;
                $data_sb_final[$idx]['bulan'] = $labels[$data_sb[$i]->month-1].' '.$data_sb[$i]->tahun;
                $idx++;
            }
        }
        // Bank Garansi
        $data_bg = GuaranteeBank::
                select(DB::raw('SUM(profit) as total_profit, MONTH(created_at) as month, YEAR(created_at) as tahun'))
                ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
                ->limit(12)
                ->get();
        $data_bg_final = [];
        if($data_bg->isEmpty()){
            for($i = 0; $i < 12; $i++){
                $data_bg_final[$i]['total_profit'] = 0;
                $data_bg_final[$i]['month'] = '-';
                $data_bg_final[$i]['bulan'] = 'Tidak ada data';
            }
        }else{
            $idx = 0;
            for($j = $idx; $j < (12-(count($data_bg)+$data_bg[0]->month-1)); $j++){
                $data_bg_final[$j]['total_profit'] = 0;
                $data_bg_final[$j]['month'] = 13+$j-(12-(count($data_bg)+$data_bg[0]->month-1));
                $data_bg_final[$j]['bulan'] = $labels[12+$j-(12-(count($data_bg)+$data_bg[0]->month-1))].' '.$data_bg[0]->tahun-1;
                $idx++;
            }
            $count = 12-(count($data_bg)+$idx);
            for($j = 1; $j < $count+1; $j++){
                $data_bg_final[$idx]['total_profit'] = 0;
                $data_bg_final[$idx]['month'] = $j;
                $data_bg_final[$idx]['bulan'] = $labels[$j-1].' '.$data_bg[0]->tahun;
                $idx++;
            }
            for($i = 0; $i < count($data_bg); $i++){
                $data_bg_final[$idx]['total_profit'] = $data_bg[$i]->total_profit;
                $data_bg_final[$idx]['month'] = $data_bg[$i]->month;
                $data_bg_final[$idx]['bulan'] = $labels[$data_bg[$i]->month-1].' '.$data_bg[$i]->tahun;
                $idx++;
            }
        }
        // Cabang -> Regional
        $data_BR = Instalment::
                select(DB::raw('SUM(nominal) as pengeluaran, MONTH(created_at) as month, YEAR(created_at) as tahun'))
                ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
                ->limit(12)
                ->get();
        $data_BR_final = [];
        if($data_BR->isEmpty()){
            for($i = 0; $i < 12; $i++){
                $data_BR_final[$i]['pengeluaran'] = 0;
                $data_BR_final[$i]['month'] = '-';
                $data_BR_final[$i]['bulan'] = 'Tidak ada data';
            }
        }else{
            $idx = 0;
            for($j = $idx; $j < (12-(count($data_BR)+$data_BR[0]->month-1)); $j++){
                $data_BR_final[$j]['pengeluaran'] = 0;
                $data_BR_final[$j]['month'] = 13+$j-(12-(count($data_BR)+$data_BR[0]->month-1));
                $data_BR_final[$j]['bulan'] = $labels[12+$j-(12-(count($data_BR)+$data_BR[0]->month-1))].' '.$data_BR[0]->tahun-1;
                $idx++;
            }
            $count = 12-(count($data_BR)+$idx);
            for($j = 1; $j < $count+1; $j++){
                $data_BR_final[$idx]['pengeluaran'] = 0;
                $data_BR_final[$idx]['month'] = $j;
                $data_BR_final[$idx]['bulan'] = $labels[$j-1].' '.$data_BR[0]->tahun;
                $idx++;
            }
            for($i = 0; $i < count($data_BR); $i++){
                $data_BR_final[$idx]['pengeluaran'] = $data_BR[$i]->pengeluaran;
                $data_BR_final[$idx]['month'] = $data_BR[$i]->month;
                $data_BR_final[$idx]['bulan'] = $labels[$data_BR[$i]->month-1].' '.$data_BR[$i]->tahun;
                $idx++;
            }
        }
        // Principal -> Cabang
        $data_RI = Payment::
                select(DB::raw('SUM(total_bill) as pemasukan, MONTH(created_at) as month, YEAR(created_at) as tahun'))
                ->where('type', 'principal_to_branch')
                ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
                ->limit(12)
                ->get();
        $data_RI_final = [];
        if($data_RI->isEmpty()){
            for($i = 0; $i < 12; $i++){
                $data_RI_final[$i]['pemasukan'] = 0;
                $data_RI_final[$i]['month'] = '-';
                $data_RI_final[$i]['bulan'] = 'Tidak ada data';
            }
        }else{
            $idx = 0;
            for($j = $idx; $j < (12-(count($data_RI)+$data_RI[0]->month-1)); $j++){
                $data_RI_final[$j]['pemasukan'] = 0;
                $data_RI_final[$j]['month'] = 13+$j-(12-(count($data_RI)+$data_RI[0]->month-1));
                $data_RI_final[$j]['bulan'] = $labels[12+$j-(12-(count($data_RI)+$data_RI[0]->month-1))].' '.$data_RI[0]->tahun-1;
                $idx++;
            }
            $count = 12-(count($data_RI)+$idx);
            for($j = 1; $j < $count+1; $j++){
                $data_RI_final[$idx]['pemasukan'] = 0;
                $data_RI_final[$idx]['month'] = $j;
                $data_RI_final[$idx]['bulan'] = $labels[$j-1].' '.$data_RI[0]->tahun;
                $idx++;
            }
            for($i = 0; $i < count($data_RI); $i++){
                $data_RI_final[$idx]['pemasukan'] = $data_RI[$i]->pengeluaran;
                $data_RI_final[$idx]['month'] = $data_RI[$i]->month;
                $data_RI_final[$idx]['bulan'] = $labels[$data_RI[$i]->month-1].' '.$data_RI[$i]->tahun;
                $idx++;
            }
        }

        return view('dashboard', [
            'agen' => $agen_count,
            'lunas' => $sb_paid,
            'non_lunas' => $sb_not_paid,
            'data_sbs' => $data_sb_final,
            'data_bgs' => $data_bg_final,
            'data_BR' => $data_BR_final,
            'data_RI' => $data_RI_final,
        ]);
    }
}
