<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class IndexController extends Controller
{
    public function index()
    {
        $current_month = date('n',strtotime(date('Y-m-d')));
        $last_month_ = $current_month - 1;

        $last_month = date('n', strtotime(date('Y').'-'.$last_month_));

        $last_month_data = Expense::where('year',date('Y'))->where('month',$last_month)->sum('amount');

        $current_month_data = Expense::where('year',date('Y'))->where('month',$current_month)->sum('amount');

        return view('admin.account.index',[
            'last_month_data' => $last_month_data,
            'current_month_data' => $current_month_data
        ]);
    }

    public function get_expense_data()
    {
        $current_month = date('n',strtotime(date('Y-m-d')));
        $last_month_ = $current_month - 1;

        $last_month = date('n', strtotime(date('Y').'-'.$last_month_));

        $months = [$last_month, $current_month];


        $data = [];
        $category_data = [];
        $i = 0;
        foreach ($months as $key => $value) {
           $categories = AccountCategory::all();

           $category = [];
           $amount = [];
           $amo = 0;
           foreach ($categories as $item) {
                $expense = Expense::where(['year'=>date('Y'), 'month'=>$value, 'category_id'=>$item->id])->first();
                $amo = 0;
                if ($expense) {
                    $amo = $expense->amount;
                }
                $category[] = $item->category;
                $amount[] = round($amo);
           }
           $date = date('Y - F', strtotime(date('Y').'-'.$value));
           $data[$i] = [
                'amount' => $amount,
                'date' => $date
           ];
           $i++;

           $category_data = $category;
        }

        return response()->json(['category_data' => $category_data, 'data' => $data]);
    }

    public function get_monthly_expense()
    {
        $months = $this->getMonths();

        $data = [];

        foreach ($months['months'] as $key => $value) {
            //Purchase Count
                $counts = Expense::where('year',date('Y'))->where('month',$value)->sum('amount');
                $data[] = round($counts);
            // End
        }

        return response()->json(['amount' => $data, 'month'=>$months['monthsName']]);
    }

    public function getMonths()
    {
        $monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','Sep','Oct','Nov','Dec'];
        $months = ['1', '2', '3', '4', '5', '6', '7', '8','9','10','11','12'];

        return ['months' => $months, 'monthsName' => $monthsName];
    }

}
