<?php

namespace App\Http\Controllers;

use App\Exports\GuaranteeBankReportProfitExcel;
use App\Exports\OtherReportInstallmentExcel;
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OtherReportPrintController
{
    private $main;

    public function __construct()
    {
        $this->main = new OtherReportController;
    }

    public function installment(Request $request)
    {
        $fileName = date("Ymd").time();

        if ($request->print == 'pdf') {
            $request->merge(['print', true]);
            $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
            $rows = $this->main->installment($request);
            $pdf = Pdf::loadView('pdf.installment', compact('name', 'rows'));
            $pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
            return $pdf->download($fileName . '.' . 'pdf');
        }
        else if ($request->print == 'excel') {
            return Excel::download(new OtherReportInstallmentExcel, $fileName . '.' . 'xlsx');
        }

        return abort(404);
    }
}
