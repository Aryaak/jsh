<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFDownloadController extends Controller
{
    public function pdf($id, $text)
    {
        $template = Template::find($id);
        $data = ['content' => $template->text,];
        $pdf = Pdf::loadView('pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
        $fileName =  $template->title . '.' . 'pdf';

        return $pdf->download($fileName);
    }

    public function pdfTemplate(Request $request)
    {
        $data = ['content' => $request->preview];
        $pdf = Pdf::loadView('pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
        $fileName =  date("Ymd").time() . '.' . 'pdf';

        return $pdf->download($fileName);
    }
}
