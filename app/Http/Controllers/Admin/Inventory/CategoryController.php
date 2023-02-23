<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\CategoryLog;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventoryCategoryController;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.inventory.category.index', [
            'categories' => $categories
        ]);
    }

    public function get_categories()
    {
        $data =  (new InventoryCategoryController)->index();
        return $data;
    }

    public function add_new()
    {
        return view('admin.inventory.category.create');
    }

    public function create(Request $request)
    {
        if ($request->is_home == true) {
            $validator = Validator::make($request->all(),
                [
                    'category_name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL',
                    'category_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                    'banner_title' => 'required',
                    'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif'
                ]
            );
        } else {
            $validator = Validator::make($request->all(),
                [
                    'category_name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL',
                    'category_image' => 'required|image|mimes:jpeg,png,jpg,gif'
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventoryCategoryController)->create($request);

        return response()->json(['status'=>true,  'message'=>'New Category Created Successfully']);

    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $category = Category::find($id);

        return view('admin.inventory.category.update',[
            'category'=>$category
        ]);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);

        if ($request->is_home == true && $category->banner_image == '') {
            $validator = Validator::make($request->all(),
                [
                    'category_name' => 'required|unique:categories,name,'.$request->id.',id,deleted_at,NULL',
                    'category_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                    'banner_title' => 'required',
                    'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif'
                ]
            );
        } else {
            $validator = Validator::make($request->all(),
                [
                    'category_name' => 'required|unique:categories,name,'.$request->id.',id,deleted_at,NULL',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $update = (new InventoryCategoryController)->update($request);

        return response()->json(['status'=>true,  'message'=>'Selected category Updated Successfully']);

    }

    public function delete($id)
    {
        $subcategory = SubCategory::where('category_id',$id)->get();
        $id = [];

        foreach($subcategory as $item)
        {
            $id[] = $item->id;
        }
        Inventory::whereIn('category_id',$id)->delete();
        SubCategory::where('category_id',$id)->delete();
        Category::destroy($id);
        return response()->json(['status'=>true,  'message'=>'Delete']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);
        $category = Category::find($id);

        return view('admin.inventory.category.logs',[
            'category'=>$category
        ]);
    }

    public function get_logs($id)
    {
        $category = CategoryLog::with(['getCreator'])->where('category_id',$id)->orderBy('id','DESC');

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
