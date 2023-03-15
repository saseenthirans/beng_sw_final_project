<?php

namespace App\Http\Controllers\Base\RepairItem;

use App\Models\Repairing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DasshboardController extends Controller
{
    public function countsMonth()
    {
        $pending = Repairing::whereYear('taken_date','=',now()->year)->whereMonth('taken_date','=',now()->month)->whereIn('status',[0,1,2])->count();

        $completed = Repairing::whereYear('taken_date','=',now()->year)->whereMonth('taken_date','=',now()->month)->whereIn('status',[3])->count();

        return [
            'pending' => $pending,
            'completed' => $completed,
            'total' => $pending + $completed
        ];
    }

    public function amountMonth()
    {
        $total = Repairing::whereYear('taken_date','=',now()->year)->whereMonth('taken_date','=',now()->month)->sum('amount');

        $paid = Repairing::whereYear('taken_date','=',now()->year)->whereMonth('taken_date','=',now()->month)->sum('adv_amount');

        return [
            'total' => $total,
            'paid' => $paid
        ];
    }

    public function repairingChart()
    {
        $months = $this->getMonths();

        $pending = [];
        $paid = [];

        foreach ($months['months'] as $key => $value) {

                $pending_ = Repairing::whereYear('updated_at','=',now()->year)->whereMonth('updated_at','=',$value)->sum(DB::raw('amount - adv_amount'));

                $paid_ = Repairing::whereYear('updated_at','=',now()->year)->whereMonth('updated_at','=',$value)->sum('adv_amount');

                $pending[] = $pending_;
                $paid[] = $paid_;
        }

        return ['pending' => $pending, 'paid' =>$paid ,'month'=>$months['monthsName']];
    }

    public function getMonths()
    {
        $monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','Sep','Oct','Nov','Dec'];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08','09','10','11','12'];

        return ['months' => $months, 'monthsName' => $monthsName];
    }
}
