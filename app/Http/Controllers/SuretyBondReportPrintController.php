<?php

namespace App\Http\Controllers;

use App\Exports\SuretyBondReportExpenseExcel;
use App\Exports\SuretyBondReportFinanceExcel;
use App\Exports\SuretyBondReportIncomeExcel;
use App\Exports\SuretyBondReportProductionExcel;
use App\Exports\SuretyBondReportProfitExcel;
use App\Exports\SuretyBondReportRemainExcel;
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SuretyBondReportPrintController
{
    private $main;

    public function __construct()
    {
        $this->main = new SuretyBondReportController;
    }

    public function production(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->production($request)->get();
            $pdf = Pdf::loadView('pdf.production', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportProductionExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }

    public function finance(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->finance($request)->get();
            $pdf = Pdf::loadView('pdf.finance', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportFinanceExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }

    public function remain(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->remain($request)->get();
            $pdf = Pdf::loadView('pdf.remain', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportRemainExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }

    public function income(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->income($request)->get();
            $pdf = Pdf::loadView('pdf.income', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportIncomeExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }

    public function expense(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->expense($request)->get();
            $pdf = Pdf::loadView('pdf.expense', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportExpenseExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }

    public function profit(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $start = date('d/m/Y', strtotime($request->params['startDate']));
            $end = date('d/m/Y', strtotime($request->params['endDate']));
            $data = $this->main->profit($request)->get();
            $pdf = Pdf::loadView('pdf.profit', compact('name', 'start', 'end', 'data'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new SuretyBondReportProfitExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }
}
