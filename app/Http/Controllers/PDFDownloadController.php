<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFDownloadController extends Controller
{
    public function pdf($id)
    {
        $template = Template::find($id);
        $data = ['content' => $template->text,];
        $pdf = Pdf::loadView('pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('images/'));
        $fileName =  $template->title . '.' . 'pdf';

        return $pdf->download($fileName);
    }
}
