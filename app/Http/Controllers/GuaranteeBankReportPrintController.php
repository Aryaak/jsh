<?php

namespace App\Http\Controllers;

use App\Exports\GuaranteeBankReportProductionExcel;
use App\Exports\GuaranteeBankReportRemainExcel;
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuaranteeBankReportPrintController
{
    private $main;

    public function __construct()
    {
        $this->main = new GuaranteeBankReportController;
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
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->stream($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new GuaranteeBankReportProductionExcel, $fileName . '.' . 'xlsx');
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
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->download($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new GuaranteeBankReportRemainExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }
}
