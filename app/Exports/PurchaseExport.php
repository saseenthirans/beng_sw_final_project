<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($supplier, $status, $start_date, $end_date)
    {
        $this->supplier = $supplier;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $query = Purchase::with(['supplier','purPayments']);

        if (isset($this->supplier) && !empty($this->supplier))
            $query = $query->where('supplier_id', $this->supplier);

        if (isset($this->status) && !empty($this->status))
            $query = $query->where('status', $this->status);

        if (isset($this->start_date) && !empty($this->start_date))
            $query = $query->whereDate('pur_date','>=', $this->start_date);

        if (isset($this->end_date) && !empty($this->end_date))
            $query = $query->whereDate('pur_date','<=', $this->end_date);

        $purchases = $query->orderBy('id', 'DESC')->get();

        $data = [];
        $i = 0;
        foreach($purchases as $item)
        {
            $i++;
            $paid_amount = 0;
            if (count($item->purPayments)) {
                $paid_amount = $item->purPayments->sum('amount');
            }

            $data[] = [
                'id' =>$i,
                'invoice'=>$item->invoice,
                'supplier' => $item->supplier->name,
                'pur_date' => $item->pur_date,
                'pur_amount' => number_format($item->pur_amount,2),
                'discount' => number_format($item->discount,2),
                'final_amount' => number_format(($item->pur_amount - $item->discount),2),
                'paid_amount' => number_format($paid_amount, 2),
                'due_amount' => number_format(($item->pur_amount - $item->discount - $paid_amount),2),
                'status' => $item->status == '0' ? 'Unsettled' : 'Settled'
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            '#',
            'Invoice No',
            'Supplier Name',
            'Purchased Date',
            'Purchased Amount',
            'Discount amount',
            'Final Amount',
            'Paid Amount',
            'Due Amount',
            'Purchased Status'
        ];
    }
}
