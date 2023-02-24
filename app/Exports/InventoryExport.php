<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data, $count, $category)
    {
        $this->data = $data;
        $this->count = $count;
        $this->category = $category;
    }

    public function view(): View
    {

        $inventory = $this->data;
        $category = $this->category;

        return view('exports.inventory', [
            'inventory' => $inventory,
            'category' => $category
        ]);
    }

    public function registerEvents() : array
    {
        $datacount = $this->count;

        $last_row = ($datacount+9);
        return [
            AfterSheet::class    => function(AfterSheet $event) use($last_row) {

                $event->sheet->getStyle('A9:G'.$last_row)->applyFromArray([
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
