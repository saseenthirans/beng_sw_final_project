<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function countAmount()
    {
        $start_date = date('Y-m-').'01';
        $end_date = date('Y-m-t');
        //Total Purchase Count
        $count = Purchase::whereDate('pur_date','>=',$start_date)->whereDate('pur_date','<=',$end_date)->count();
        $purchases = Purchase::whereDate('pur_date','>=',$start_date)->whereDate('pur_date','<=',$end_date)->get();

        $pur_total = 0;
        $pur_id = [];
        foreach($purchases as $item)
        {
            $pur_total = $pur_total + ($item->pur_amount - $item->discount);
            $pur_id[] = $item->id;
        }

        $total_paid = PurchasePayment::whereDate('paid_date','>=',$start_date)->whereDate('paid_date','<=',$end_date)->whereIn('pur_id',$pur_id)->sum('amount');

        $due = $pur_total - $total_paid;

        $supplier = Supplier::where('status',1)->count();

        $inventory = Inventory::where('status',1)->sum('qty');

        return [
            'count' => $count,
            'pur_total' => $pur_total,
            'total_paid' => $total_paid,
            'due' => $due,
            'supplier' => $supplier,
            'inventory' => $inventory
        ];
    }

    public function purchaseChart()
    {
        $months = $this->getMonths();

        $data = [];

        foreach ($months['months'] as $key => $value) {
            //Purchase Count
                $counts = Purchase::whereYear('pur_date','=',now()->year)->whereMonth('pur_date','=',$value)->count();
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
