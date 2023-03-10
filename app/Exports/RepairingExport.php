<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RepairingExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $count;
    private $request;
    private $category;

    public function __construct($data, $count, $request, $category)
    {
        $this->data = $data;
        $this->count = $count;
        $this->request = $request;
        $this->category = $category;
    }

    public function view(): View
    {

        $repairing = $this->data;
        $request = $this->request;
        $category = $this->category;

        return view('exports.repairing', [
            'repairing' => $repairing,
            'request' => $request,
            'category' => $category
        ]);
    }

    public function registerEvents() : array
    {
        $datacount = $this->count;

        $last_row = ($datacount+10);
        return [
            AfterSheet::class    => function(AfterSheet $event) use($last_row) {

                $event->sheet->getStyle('A9:K'.$last_row)->applyFromArray([
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
