<?php

namespace App\Traits\ExcelFormatter;

use App\Models\Branch;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait FormatterIncomeReport
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
        $data = $this->main->income($request)->get();

        $this->startRows = ($request->branch || $request->regional) ? 5 : 4;
        $this->totalRows = $data->count() + $this->startRows;
        if ($data->count() == 0) $this->totalRows++;

        return view('excel.income', compact('name', 'start', 'end', 'data'));
    }

    public function columnFormats(): array
    {
        return [
            'B' => '[$-21]dd mmmm yyyy h:mm:ss',
            'F' => '"Rp"#,##0.000',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'G') as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($this->startRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tableBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ];

        $sheet->getStyle("A{$this->startRows}:G{$this->totalRows}")->applyFromArray($tableBorder);

        for ($row = 1; $row <= $this->totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(21,'pt');
        }
    }
}
