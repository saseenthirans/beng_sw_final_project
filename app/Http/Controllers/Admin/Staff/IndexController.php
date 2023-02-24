<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaffSalary;

class IndexController extends Controller
{
    public function index()
    {
        $staffcount = $this->staffCount();

        return view('admin.staff.index',[
            'staffcount' => $staffcount
        ]);
    }

    public function staffCount()
    {
        $status = ['0'=>'Inactive', '1' => 'Active'];

        $data = [];
        foreach ($status as $key => $value) {
            $count = User::role('Staff')->where('status', $key)->count();

            $data[$key] = $count;
        }

        return $data;
    }

    public function get_monthly_salary()
    {
        $months = $this->getMonths();

        $data = [];

        foreach ($months['months'] as $key => $value) {
            //Purchase Count
                $counts = StaffSalary::whereYear('updated_at','=',now()->year)->whereMonth('updated_at','=',$value)->sum('paid_amount');
                $data[] = $counts;
            // End
        }

        return response()->json(['amount' => $data, 'month'=>$months['monthsName']]);
    }

    public function getMonths()
    {
        $monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','Sep','Oct','Nov','Dec'];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08','09','10','11','12'];

        return ['months' => $months, 'monthsName' => $monthsName];
    }

}
