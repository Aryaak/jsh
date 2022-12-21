<?php

namespace App\Traits\ExcelFormatter;

use App\Models\Branch;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait FormatterProductionReport
{
    private $main;
    private $startRows;
    private $totalRows;

    public function view(): View
    {
        $request = request()->merge(['print', true]);
        $name = ($request->branch) ? Branch::where('slug', $request->branch)->first()->name : (($request->regional) ? Branch::where('slug', $request->regional)->first()->name : '');
        $start = date('d/m/Y', strtotime($request->params['startDate']));
        $end = date('d/m/Y', strtotime($request->params['endDate']));
        $data = $this->main->production($request)->get();

        $this->startRows = ($request->branch || $request->regional) ? 5 : 4;
        $this->totalRows = $data->count() + 2 + $this->startRows;
        if ($data->count() == 0) $this->totalRows++;

        return view('excel.production', compact('name', 'start', 'end', 'data'));
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"Rp"#,##0.00',
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => '"Rp"#,##0.00',
            'J' => '"Rp"#,##0.00',
            'K' => '"Rp"#,##0.00',
            'L' => '"Rp"#,##0.00',
            'M' => '"Rp"#,##0.00',
            'N' => '"Rp"#,##0.00',
            'O' => '"Rp"#,##0.00',
            'P' => '"Rp"#,##0.00',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'R') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('R')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows + 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tableBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ];

        $sheet->getStyle("A{$this->startRows}:R{$this->totalRows}")->applyFromArray($tableBorder);

        for ($row = 1; $row <= $this->totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(21,'pt');
        }
    }
}
