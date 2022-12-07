<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DesignController
{
    public function page(Request $request, $page)
    {
        return view("designs.$page");
    }

    public function pdf(Request $request, $page)
    {
        $pdf = Pdf::loadView("designs.pdf.$page");
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }
}
