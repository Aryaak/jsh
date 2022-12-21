<?php

namespace App\Exports;

use App\Http\Controllers\GuaranteeBankReportController;
use App\Traits\ExcelFormatter\FormatterFinanceReport;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;

class GuaranteeBankReportFinanceExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    use FormatterFinanceReport;

    public function __construct()
    {
        $this->main = new GuaranteeBankReportController;
    }
}
