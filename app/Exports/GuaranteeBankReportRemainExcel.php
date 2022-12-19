<?php

namespace App\Exports;

use App\Http\Controllers\SuretyBondReportController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class GuaranteeBankReportRemainExcel implements FromView, ShouldAutoSize, WithColumnWidths
{
    private $main;

    public function __construct()
    {
        $this->main = new SuretyBondReportController;
    }

    public function view(): View
    {
        $request = request()->merge(['print', true]);
        $data = $this->main->remain($request)->get();

        return view('pdf.remain', compact('data'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
        ];
    }
}
