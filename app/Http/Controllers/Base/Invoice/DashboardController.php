<?php

namespace App\Http\Controllers\Base\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countAmount()
    {
        $status = [0,1];

        $data = [];
        foreach ($status as $key => $value) {
            $invoice = Invoice::with('invoicePayment')->where('status',$value)->whereMonth('invoice_date', '=', now()->month)->get();

            $count = 0;
            $total = 0;
            $paid = 0;
            foreach ($invoice as $item) {
                $count++;
                $total = $total + $item->total;
                $paid = $paid + $item->invoicePayment->sum('amount');
            }

            $data[$value] = [
                'count' => $count,
                'total' =>$total,
                'paid' => $paid
            ];
        }

        return $data;
    }

    public function invoiceChart()
    {
        $months = $this->getMonths();

        $data = [];

        foreach ($months['months'] as $key => $value) {
            //Purchase Count
                $counts = Invoice::whereYear('invoice_date','=',now()->year)->whereMonth('invoice_date','=',$value)->count();
                $data[] = $counts;
            // End
        }

        return ['count' => $data, 'month'=>$months['monthsName']];
    }

    public function getMonths()
    {
        $monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','Sep','Oct','Nov','Dec'];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08','09','10','11','12'];

        return ['months' => $months, 'monthsName' => $monthsName];
    }
}
