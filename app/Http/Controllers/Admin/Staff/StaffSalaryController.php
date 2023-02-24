<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Exports\StaffSalaryExport;
use App\Models\User;
use App\Models\UserSalary;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\ExportController;

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

    public function get_salary(Request $request)
    {
        $query = StaffSalary::with('staff');
            if (isset($request->staff) && !empty($request->staff))
                $query = $query->where('user_id',$request->staff);

            if (isset($request->start_date) && !empty($request->start_date))
                $query = $query->whereDate('updated_at','>=', $request->start_date);

            if (isset($request->end_date) && !empty($request->end_date))
                $query = $query->whereDate('updated_at','<=', $request->end_date);

        $salary = $query->orderBy('id','DESC');

        $data =  Datatables::of($salary)
            ->addIndexColumn()
            ->addColumn('name', function ($item) {
                return $item->staff->name;
             })
            ->addColumn('basic_salary', function ($item) {
                return $item->staff->basicSalary->salary;
            })
            ->addColumn('paid_year_month', function ($item) {
                $year_month = $item->paid_year.'-'.$item->paid_month;

                return date('Y F', strtotime($year_month));
            })
            ->addColumn('updated_date', function ($item) {
               return date('Y-m-d', strtotime($item->updated_at));
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/staffs/salary/update/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';

                }
            })
            ->rawColumns(['paid_year_month','updated_date' ,'name','action','basic_salary'])
            ->make(true);

        return $data;
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
        $id = NULL;
        if(isset($request->id) && !empty($request->id))
        {
            $id = $request->id;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|unique:staff_salaries,user_id,'.$id.',id,paid_year,'.$request->year.',paid_month,'.$request->month,
            ],
            [
               'user_id.unique'=>'Selected Staff Salary Details already exists'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $staff = User::find($request->user_id);
        $salary = $staff->basicSalary->salary;

        return response()->json(['status'=>true, 'salary' => $salary]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'staff' => 'required|unique:staff_salaries,user_id,NULL,id,paid_year,'.$request->year.',paid_month,'.$request->month,
                'paid_year' => 'required',
                'paid_month' => 'required',
                'salary' => 'required|numeric|between:0,9999999999.99'
            ],
            [
               'staff.unique'=>'Selected Staff Salary Details already exists'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $salary = new StaffSalary();
        $salary->user_id = $request->staff;
        $salary->paid_amount = $request->salary;
        $salary->paid_year = $request->paid_year;
        $salary->paid_month = $request->paid_month;
        $salary->save();

        return response()->json(['status'=>true, 'message'=>'New Salary Details Added Succesfully']);

    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $salary = StaffSalary::find($id);
        $staffs = User::role('Staff')->where('status',1)->orderBy('id', 'DESC')->get();

        return view('admin.staff.salary.update', [
            'salary' => $salary,
            'staffs' => $staffs
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make(
            $request->all(),
            [
                'staff' => 'required|unique:staff_salaries,user_id,'.$id.',id,paid_year,'.$request->year.',paid_month,'.$request->month,
                'paid_year' => 'required',
                'paid_month' => 'required',
                'salary' => 'required|numeric|between:0,9999999999.99'
            ],
            [
               'staff.unique'=>'Selected Staff Salary Details already exists'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $salary = StaffSalary::find($id);
        $salary->user_id = $request->staff;
        $salary->paid_amount = $request->salary;
        $salary->paid_year = $request->paid_year;
        $salary->paid_month = $request->paid_month;
        $salary->update();

        return response()->json(['status'=>true, 'message'=>'Selected Salary Details Updated Succesfully']);
    }

    public function delete($id)
    {
        StaffSalary::destroy($id);
        return response()->json(['status'=>true, 'message'=>'Selected Salary Details Deleted Succesfully']);
    }

    public function export(Request $request)
    {
        $data = (new ExportController)->staffSalaryExport($request);

        $staff_name = '';
        if (isset($request->staff) && !empty($request->staff))
        {
            $staff = User::find($request->staff);
            $staff_name = $staff->name;
        }

        $file_name = 'purchased' . date('_YmdHis') . '.xlsx';
        return Excel::download(new StaffSalaryExport($data, count($data),$request,$staff_name), $file_name);
    }

}
