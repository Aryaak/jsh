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
            'Desember',
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
        ];


        $agen_count = Agent::all()->count();
        $sb_paid = DB::table('surety_bond_statuses')->where('status_id','=',13)->count();
        $sb_not_paid = DB::table('surety_bond_statuses')->where('status_id','=',14)->count();
        // Surety Bonds
        $data_sb = SuretyBond::
                select(DB::raw('SUM(profit) as total_profit, MONTH(document_expired_at) as month, YEAR(document_expired_at) as tahun'))
                ->groupBy(DB::raw('MONTH(document_expired_at), YEAR(document_expired_at)'))
                // ->orderBy('document_expired_at', 'ASC')
                ->limit(12)
                ->get();
        $data_sb_final = [];
        for($i = 0; $i < (12-count($data_sb)); $i++){
            $month_idx = $i+count($data_sb);
            $bulan = $labels[$month_idx].' 2022';
            array_push($data_sb_final, ['total_profit'=>0,'month'=>$month_idx, 'bulan'=>$bulan]);
        }
        for($i = 0; $i < count($data_sb); $i++){
            $month_idx = $i;
            $bulan = $labels[$month_idx].' '.$data_sb[$i]->tahun;
            array_push($data_sb_final, ['total_profit'=>$data_sb[$i]->total_profit,'month'=>$data_sb[$i]->month, 'bulan'=>$bulan]);
        }

        // Bank Garansi
        $data_bg = GuaranteeBank::
                select(DB::raw('SUM(profit) as total_profit, MONTH(document_expired_at) as month, YEAR(document_expired_at) as tahun'))
                ->groupBy(DB::raw('MONTH(document_expired_at), YEAR(document_expired_at)'))
                // ->orderBy('document_expired_at', 'ASC')
                ->limit(12)
                ->get();
        $data_bg_final = [];
        for($i = 0; $i < (12-count($data_bg)); $i++){
            $month_idx = $i+count($data_bg);
            $bulan = $labels[$month_idx].' 2022';
            array_push($data_bg_final, ['total_profit'=>0,'month'=>$i, 'bulan'=>$bulan]);
        }
        for($i = 0; $i < count($data_bg); $i++){
            $month_idx = $i;
            $bulan = $labels[$month_idx].' '.$data_bg[$i]->tahun;
            array_push($data_bg_final, ['total_profit'=>$data_bg[$i]->total_profit,'month'=>$data_bg[$i]->month, 'bulan'=>$bulan]);
        }

        // Cabang -> Regional
        $data_BR = Instalment::
                select(DB::raw('SUM(nominal) as pengeluaran, MONTH(paid_at) as month, YEAR(paid_at) as tahun'))
                ->groupBy(DB::raw('MONTH(paid_at), YEAR(paid_at)'))
                // ->orderBy('paid_at', 'ASC')
                ->limit(12)
                ->get();
        $data_BR_final = [];
        for($i = 0; $i < (12-count($data_BR)); $i++){
            $month_idx = $i+count($data_BR);
            $bulan = $labels[$month_idx].' 2022';
            array_push($data_BR_final, ['pengeluaran'=>0,'month'=>$i, 'bulan'=>$bulan]);
        }
        for($i = 0; $i < count($data_BR); $i++){
            $month_idx = $i;
            $bulan = $labels[$month_idx].' '.$data_BR[$i]->tahun;
            array_push($data_BR_final, ['pengeluaran'=>$data_BR[$i]->pengeluaran,'month'=>$data_BR[$i]->month, 'bulan'=>$bulan]);
        }

        // Principal -> Cabang
        $data_RI = Payment::
                select(DB::raw('SUM(total_bill) as pemasukan, MONTH(paid_at) as month, YEAR(paid_at) as tahun'))
                ->where('type', 'principal_to_branch')
                ->groupBy(DB::raw('MONTH(paid_at), YEAR(paid_at)'))
                // ->orderBy('paid_at', 'ASC')
                ->limit(12)
                ->get();
        $data_RI_final = [];
        for($i = 0; $i < (12-count($data_RI)); $i++){
            $month_idx = $i+count($data_RI);
            $bulan = $labels[$month_idx].' 2022';
            array_push($data_RI_final, ['pemasukan'=>0,'month'=>$i, 'bulan'=>$bulan]);
        }
        for($i = 0; $i < count($data_RI); $i++){
            $month_idx = $i;
            $bulan = $labels[$month_idx].' '.$data_RI[$i]->tahun;
            array_push($data_RI_final, ['pemasukan'=>$data_RI[$i]->pemasukan,'month'=>$data_RI[$i]->month, 'bulan'=>$bulan]);
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
