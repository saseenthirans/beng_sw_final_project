<?php

namespace App\Http\Controllers\Admin\Account;

use App\Exports\AccountsExport;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\AccountCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();

        $years = Expense::distinct('year')->pluck('year')->toArray();

        return view('admin.account.expense.index',[
            'expense' => $expense,
            'years' => $years
        ]);
    }

    public function get_expense(Request $request)
    {
        $query = Expense::with('getCategory');
                if(isset($request->year) && !empty($request->year))
                    $query = $query->where('year',$request->year);

                if(isset($request->month) && !empty($request->month))
                    $query = $query->where('month',$request->month);

        $expense = $query->orderBy('id','DESC');

        $data =  Datatables::of($expense)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return ucwords($item->getCategory->category);
            })
            ->addColumn('year_month', function ($item) {
                $year_month = $item->year.'-'.$item->month;
                return date('Y - F', strtotime($year_month));
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/accounts/expense/update/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';

                }
            })
            ->rawColumns(['action','category'])
            ->make(true);

        return $data;
    }

    public function create_form()
    {
        $category = AccountCategory::all();

        return view('admin.account.expense.create', ['category' => $category]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'year' => 'required',
                'month' => 'required',
                'category' => 'required|unique:expenses,category_id,NULL,id,deleted_at,NULL,year,'.$request->year.',month,'.$request->month.'',
                'paid_date' => 'required|after:yesterday',
                'amount' => 'required|numeric|between:0,9999999999.99',
            ],
            [
                'category.unique' => 'The selected expense has already been taken'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $expense = new Expense();
        $expense->category_id = $request->category;
        $expense->year = $request->year;
        $expense->month = $request->month;
        $expense->amount = $request->amount;
        $expense->paid_date = $request->paid_date;
        $expense->save();

        return response()->json(['status' => true, 'message' => 'New Expense Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $expense = Expense::find($id);
        $category = AccountCategory::all();

        return view('admin.account.expense.update', [
            'category' => $category,
            'expense' => $expense
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make(
            $request->all(),
            [
                'year' => 'required',
                'month' => 'required',
                'category' => 'required|unique:expenses,category_id,'.$id.',id,deleted_at,NULL,year,'.$request->year.',month,'.$request->month.'',
                'paid_date' => 'required|after:yesterday',
                'amount' => 'required|numeric|between:0,9999999999.99',
            ],
            [
                'category.unique' => 'The selected expense has already been taken'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $expense = Expense::find($id);
        $expense->category_id = $request->category;
        $expense->year = $request->year;
        $expense->month = $request->month;
        $expense->amount = $request->amount;
        $expense->paid_date = $request->paid_date;
        $expense->update();

        return response()->json(['status' => true, 'message' => 'Selected Expense Updated Successfully']);
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        Expense::destroy($id);
        return response()->json(['status' => true, 'message' => 'Selected Expense Deleted Successfully']);
    }

    public function export(Request $request)
    {
        $query = Expense::with('getCategory');
                if(isset($request->year) && !empty($request->year))
                    $query = $query->where('year',$request->year);

                if(isset($request->month) && !empty($request->month))
                    $query = $query->where('month',$request->month);

        $expense = $query->orderBy('id','DESC')->get();

        $file_name = 'purchased' . date('_YmdHis') . '.xlsx';

        return Excel::download(new AccountsExport($expense, count($expense),$request), $file_name);
    }
}
