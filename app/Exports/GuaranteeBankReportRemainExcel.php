<?php

namespace App\Exports;

use App\Http\Controllers\GuaranteeBankReportController;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Traits\ExcelFormatter\FormatterRemainReport;

class GuaranteeBankReportRemainExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    use FormatterRemainReport;

    public function __construct()
    {
        $this->main = new GuaranteeBankReportController;
    }
}
