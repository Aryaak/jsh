<?php

namespace App\Exports;

use App\Http\Controllers\SuretyBondReportController;
use App\Traits\ExcelFormatter\FormatterIncomeReport;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;

class SuretyBondReportIncomeExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    use FormatterIncomeReport;

    public function __construct()
    {
        $this->main = new SuretyBondReportController;
    }
}
