<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Http\Request;
use App\Models\AccountCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.account.category.index');
    }

    public function get_categories()
    {
        $category = AccountCategory::orderBy('id','DESC');

        $data =  Datatables::of($category)
            ->addIndexColumn()
            ->addColumn('name', function ($item) {
                return ucwords($item->category);
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    return '<a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation('. $item->id . ')" data-id="'. $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';

                }
            })
            ->rawColumns(['action','name'])
            ->make(true);

        return $data;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'category_name' => 'required|unique:account_categories,category,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $category = new AccountCategory();
        $category->category = $request->category_name;
        $category->save();

        return response()->json(['status'=>true,  'message'=>'New Category Created Successfully']);
    }

    public function delete(Request $request)
    {
        AccountCategory::destroy($request->id);

        return response()->json(['status'=>true,  'message'=>'Selected Category Deleted Successfully']);
    }
}
