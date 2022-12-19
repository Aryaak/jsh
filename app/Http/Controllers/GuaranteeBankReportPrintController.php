<?php

namespace App\Http\Controllers;

use App\Exports\GuaranteeBankReportRemainExcel;
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

    public function remain(Request $request, $print)
    {
        $fileName = date("Ymd").time();

        if ($print == 'pdf') {
            $request->merge(['print', true]);
            $data = $this->main->remain($request)->get();
            $pdf = Pdf::loadView('pdf.remain', compact('data'));
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->download($fileName . '.' . 'pdf');
        }
        else if ($print == 'excel') {
            return Excel::download(new GuaranteeBankReportRemainExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }
}
