<?php

namespace App\Exports;

use App\Http\Controllers\OtherReportController;
use App\Models\Branch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OtherReportProfitExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private $main;
    private $startRows;
    private $totalRows;

    public function __construct()
    {
        $this->main = new OtherReportController;
    }

    public function view(): View
    {
        $request = request()->merge(['print', true]);
        $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
        $start = date('d/m/Y', strtotime($request->params['startDate']));
        $end = date('d/m/Y', strtotime($request->params['endDate']));
        $data = $this->main->profit($request);

        $this->startRows = ($request->branch || $request->regional) ? 5 : 4;
        $this->totalRows = count($data) + 1 + $this->startRows;
        if (count($data) == 0) $this->totalRows++;

        return view('excel.other-profit', compact('name', 'start', 'end', 'data'));
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"Rp"#,##0.00',
            'E' => '"Rp"#,##0.00',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'E') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tableBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ];

        $sheet->getStyle("A{$this->startRows}:E{$this->totalRows}")->applyFromArray($tableBorder);

        for ($row = 1; $row <= $this->totalRows + 4; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(21,'pt');
        }
    }
}
