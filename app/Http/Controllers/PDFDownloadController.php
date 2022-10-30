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
        $pdf = Pdf::loadView('master.pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('images/content/'));
        $fileName =  time() . '.' . 'pdf';

        return $pdf->download($fileName);
    }
}
