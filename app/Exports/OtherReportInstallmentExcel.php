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

class OtherReportInstallmentExcel implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles
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
        $data = $this->main->installment($request);

        $this->startRows = ($request->branch || $request->regional) ? 5 : 4;
        $this->totalRows = count($data) + $this->startRows;
        if (count($data) == 0) $this->totalRows++;

        return view('excel.installment', compact('name', 'data'));
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => '"Rp"#,##0.000',
            'C' => '"Rp"#,##0.000',
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => '"Rp"#,##0.000',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'F') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C'.$this->totalRows + 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C'.$this->totalRows + 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C'.$this->totalRows + 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D'.$this->totalRows + 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D'.$this->totalRows + 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D'.$this->totalRows + 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D'.$this->totalRows + 2)->getNumberFormat()->setFormatCode('"Rp"#,##0.000');
        $sheet->getStyle('D'.$this->totalRows + 3)->getNumberFormat()->setFormatCode('"Rp"#,##0.000');
        $sheet->getStyle('D'.$this->totalRows + 4)->getNumberFormat()->setFormatCode('"Rp"#,##0.000');

        $tableBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ];

        $sheet->getStyle("A{$this->startRows}:F{$this->totalRows}")->applyFromArray($tableBorder);

        for ($row = 1; $row <= $this->totalRows + 4; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(21,'pt');
        }
    }
}
