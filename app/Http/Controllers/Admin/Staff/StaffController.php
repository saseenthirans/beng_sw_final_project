<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Models\User;
use App\Models\Company;
use App\Models\UserSalary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\HelperController;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::role('Staff')->orderBy('id','DESC')->get();

        return view('admin.staff.staff.index',[
            'staffs' => $staffs
        ]);
    }

    public function get_staffs(Request $request)
    {
        if (isset($request->status) && !empty($request->status)) {
            $staffs = User::role('Staff')->where('status', $request->status)->orderBy('id', 'DESC');
        } else {
            $staffs = User::role('Staff')->orderBy('id', 'DESC');
        }

        $data =  Datatables::of($staffs)
            ->addIndexColumn()

            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return '<span class="badge badge-danger">Inactive</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })
            ->addColumn('basic_salary', function ($item) {
                if ($item->basicSalary->salary) {
                    return $item->basicSalary->salary;
                }
                else
                {
                    return '0.00';
                }
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/staffs/staffs/update/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';

                }
            })
            ->rawColumns(['status', 'action','basic_salary'])
            ->make(true);

        return $data;
    }

    public function add_new()
    {
        return view('admin.staff.staff.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'last_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'contact' => 'required|digits:10|unique:users,contact,NULL,id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
                'basic_salary' => 'required|numeric|between:0,9999999999.99',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $password = Str::random(8);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name.' '.$request->last_name;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->status = $request->status == true ? 1 : 0;
        $user->password = Hash::make($password);
        $user->image = 'upload/users/user.png';
        $user->save();

        //Salary
        $salary = new UserSalary();
        $salary->user_id = $user->id;
        $salary->salary = $request->basic_salary;
        $salary->save();

        $user->assignRole('Staff');

        $company = Company::find(1);
        //Email Sending
            $data["email"] = $user->email;
            $data["name"] = $user->name;
            $data["password"] = $password;
            $data["title"] = "Welcome To ".$company->name;
            $data["view"] = "admin.staff.staff.welcome";

            (new HelperController)->welcomeMail($data);
        //End

        return response()->json(['status' => true,  'message' => 'New Staff Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $staffs = User::find($id);

        return view('admin.staff.staff.update',[
            'staffs'=>$staffs
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'last_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'contact' => 'required|digits:10|unique:users,contact,'.$id.',id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL',
                'basic_salary' => 'required|numeric|between:0,9999999999.99',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name.' '.$request->last_name;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->status = $request->status == true ? 1 : 0;
        $user->update();

        //Salary
        $salary = UserSalary::where('user_id',$id)->first();
        $salary->salary = $request->basic_salary;
        $salary->update();

        return response()->json(['status' => true,  'message' => 'Selected Staff Updated Successfully']);
    }

    public function delete($id)
    {
        User::destroy($id);
        return response()->json(['status' => true,  'message' => 'Selected Staff deleted Successfully']);
    }
}
