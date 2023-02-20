<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\Invoice\CustomerController as InvoiceCustomerController;
use App\Models\CustomerLog;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('admin.invoice.customers.index',[
            'customers' => $customers
        ]);
    }

    public function get_customers(Request $request)
    {
        $data =  (new InvoiceCustomerController)->index($request);
        return $data;
    }

    public function add_new()
    {
        return view('admin.invoice.customers.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'last_name' => 'required|regex:/^[a-z A-Z]+$/u',
                'contact' => 'required|digits:10|unique:customers,contact,NULL,id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:customers,email,NULL,id,deleted_at,NULL',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InvoiceCustomerController)->create($request);

        return response()->json(['status' => true,  'message' => 'New Customer Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $customer = Customer::Find($id);

        return view('admin.invoice.customers.update',[
            'customer' => $customer
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
                'contact' => 'required|digits:10|unique:customers,contact,'.$id.',id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:customers,email,'.$id.',id,deleted_at,NULL',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InvoiceCustomerController)->update($request);

        return response()->json(['status' => true,  'message' => 'Selected Customer Updated Successfully']);
    }

    public function delete($id)
    {
        Customer::destroy($id);
        return response()->json(['status' => true,  'message' => 'Selected Customer Deleted Successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);

        $customer = Customer::Find($id);

        return view('admin.invoice.customers.logs',[
            'customer' => $customer
        ]);
    }

    public function get_logs($id)
    {
        $category = CustomerLog::with(['getCreator'])->where('cus_id',$id)->orderBy('id','DESC');

        $data =  Datatables::of($category)
            ->addIndexColumn()

            ->addColumn('created', function ($item) {
                return ucwords($item->getCreator->name);
            })
            ->addColumn('acc_date', function ($item) {
                return date('Y-m-d h:i:s A', strtotime($item->created_at));
            })
            ->rawColumns(['created','acc_date'])
            ->make(true);

        return $data;
    }
}
