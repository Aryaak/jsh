<?php

namespace App\Traits\ExcelFormatter;

use App\Models\Branch;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait FormatterProfitReport
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
        $data = $this->main->profit($request)->get();

        $this->startRows = ($request->branch || $request->regional) ? 5 : 4;
        $this->totalRows = $data->count() + $this->startRows;
        if ($data->count() == 0) $this->totalRows++;

        return view('excel.profit', compact('name', 'start', 'end', 'data'));
    }

    public function columnFormats(): array
    {
        return [
            'C' => '"Rp"#,##0.00',
            'D' => '"Rp"#,##0.00',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'D') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tableBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ];

        $sheet->getStyle("A{$this->startRows}:D{$this->totalRows}")->applyFromArray($tableBorder);

        for ($row = 1; $row <= $this->totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(21,'pt');
        }
    }
}
