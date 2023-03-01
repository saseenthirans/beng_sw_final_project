<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data, $count, $request, $customer)
    {
        $this->data = $data;
        $this->count = $count;
        $this->request = $request;
        $this->customer = $customer;
    }

    public function view(): View
    {

        $invoices = $this->data;
        $request = $this->request;
        $customer = $this->customer;

        return view('exports.invoice', [
            'invoices' => $invoices,
            'request' => $request,
            'customer' => $customer
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
