<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventorySubCategoryController;
use App\Models\SubCategory;
use App\Models\SubCategoryLog;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.inventory.sub_category.index', [
            'categories' => $categories
        ]);
    }

    public function get_subcategories(Request $request)
    {
        $data =  (new InventorySubCategoryController)->index($request);
        return $data;
    }

    public function add_new()
    {
        $categories = Category::where('status',1)->get();

        return view('admin.inventory.sub_category.create',[
            'categories' =>$categories
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'category' => 'required',
                'sub_category_name' => 'required|unique:sub_categories,name,NULL,id,deleted_at,NULL,category_id,'.$request->category
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventorySubCategoryController)->create($request);

        return response()->json(['status'=>true,  'message'=>'New Subcategory Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $categories = Category::where('status',1)->get();

        $category = SubCategory::find($id);

        return view('admin.inventory.sub_category.update',[
            'categories' =>$categories,
            'category' => $category
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'category' => 'required',
                'sub_category_name' => 'required|unique:sub_categories,name,'.$request->id.',id,deleted_at,NULL,category_id,'.$request->category
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventorySubCategoryController)->update($request);

        return response()->json(['status'=>true,  'message'=>'Selected Subcategory Updated Successfully']);
    }

    public function delete($id)
    {
        SubCategory::destroy($id);
        return response()->json(['status'=>true,  'message'=>'Delete']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);

        $category = SubCategory::find($id);

        return view('admin.inventory.sub_category.logs',[
            'category' =>$category
        ]);
    }

    public function get_logs($id)
    {
        $category = SubCategoryLog::with(['getCreator'])->where('sub_category_id',$id)->orderBy('id','DESC');

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
