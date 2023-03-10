<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchaseExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $count;
    private $request;
    private $supplier;

    public function __construct($data, $count, $request, $supplier)
    {
        $this->data = $data;
        $this->count = $count;
        $this->request = $request;
        $this->supplier = $supplier;
    }

    public function view(): View
    {

        $purchases = $this->data;
        $request = $this->request;
        $supplier = $this->supplier;

        return view('exports.purchase', [
            'purchases' => $purchases,
            'request' => $request,
            'supplier' => $supplier
        ]);
    }

    public function registerEvents() : array
    {
        $datacount = $this->count;

        $last_row = ($datacount+10);
        return [
            AfterSheet::class    => function(AfterSheet $event) use($last_row) {

                $event->sheet->getStyle('A9:J'.$last_row)->applyFromArray([
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
