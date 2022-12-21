<?php

namespace App\Exports;

use App\Http\Controllers\SuretyBondReportController;
use App\Traits\ExcelFormatter\FormatterProfitReport;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;

class SuretyBondReportProfitExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    use FormatterProfitReport;

    public function __construct()
    {
        $this->main = new SuretyBondReportController;
    }
}
