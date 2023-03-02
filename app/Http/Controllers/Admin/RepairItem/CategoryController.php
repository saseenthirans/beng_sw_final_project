<?php

namespace App\Http\Controllers\Admin\RepairItem;

use Illuminate\Http\Request;
use App\Models\RepairCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\RepairItem\CategoryController as RepairItemCategoryController;
use App\Models\RepairCategoryLog;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = RepairCategory::all();

        return view('admin.repair_item.category.index',[
            'categories'=>$categories
        ]);
    }

    public function get_categories()
    {
        $data = (new RepairItemCategoryController)->index();

        return $data;
    }

    public function add_new()
    {
        return view('admin.repair_item.category.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'category_name' => 'required|unique:repair_categories,category,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new RepairItemCategoryController)->create($request);

        return response()->json(['status'=>true,  'message'=>'New Category Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $category = RepairCategory::find($id);

        return view('admin.repair_item.category.update',[
            'category' => $category
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(),
        [
            'category_name' => 'required|unique:repair_categories,category,'.$id.',id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new RepairItemCategoryController)->update($request);

        return response()->json(['status'=>true,  'message'=>'Selected Category Updated Successfully']);
    }

    public function delete(Request $request)
    {
        RepairCategory::destroy($request->id);

        return response()->json(['status'=>true,  'message'=>'Selected Category Deleted Successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);

        $category = RepairCategory::find($id);

        return view('admin.repair_item.category.logs',[
            'category' => $category
        ]);
    }

    public function get_logs($id)
    {
        $category = RepairCategoryLog::with(['getCreator'])->where('category_id',$id)->orderBy('id','DESC');

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
