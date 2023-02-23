<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Models\User;
use App\Models\UserSalary;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StaffSalaryController extends Controller
{
    public function index()
    {
        $salary = StaffSalary::all();
        $staffs = User::role('Staff')->orderBy('id', 'DESC')->get();

        return view('admin.staff.salary.index',[
            'salary' => $salary,
            'staffs' => $staffs
        ]);
    }

    public function add_new()
    {
        $staffs = User::role('Staff')->where('status',1)->orderBy('id', 'DESC')->get();

        return view('admin.staff.salary.create',[
            'staffs' =>$staffs
        ]);
    }

    public function validation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|unique:staff_salaries,user_id,NULL,id,paid_year,'.$request->year.',paid_month,'.$request->month,
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }
    }
}
