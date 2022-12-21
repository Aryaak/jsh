<?php

namespace App\Exports;

use App\Http\Controllers\SuretyBondReportController;
use App\Traits\ExcelFormatter\FormatterProductionReport;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;

class SuretyBondReportProductionExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    use FormatterProductionReport;

    public function __construct()
    {
        $this->main = new SuretyBondReportController;
    }
}
