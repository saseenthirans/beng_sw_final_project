<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StaffSalaryExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $count;
    private $request;
    private $staff;

    public function __construct($data, $count, $request, $staff)
    {
        $this->data = $data;
        $this->count = $count;
        $this->request = $request;
        $this->staff = $staff;
    }

    public function view(): View
    {

        $salary = $this->data;
        $request = $this->request;
        $staff = $this->staff;

        return view('exports.staff_salary', [
            'salary' => $salary,
            'request' => $request,
            'staff' => $staff
        ]);
    }

    public function registerEvents() : array
    {
        $datacount = $this->count;

        $last_row = ($datacount+11);
        return [
            AfterSheet::class    => function(AfterSheet $event) use($last_row) {

                $event->sheet->getStyle('A10:F'.$last_row)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
