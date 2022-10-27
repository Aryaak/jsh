<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFDownloadController extends Controller
{
    public function pdf(Request $request)
    {
        $template = Template::find($request->id);
        $data = ['content' => $template->text,];
        $pdf = Pdf::loadView('master.pdf', $data);

        $path = public_path('pdf/');
        $fileName =  time() . '.' . 'pdf';
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);
        // return view('pdf');
    }
}
