<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventoryInventoryController;
use App\Models\InventoryLog;
use App\Models\Sales;
use Yajra\DataTables\DataTables;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        $categories = Category::with('activeSubCategory')->where('status',1)->get();

        return view('admin.inventory.inventory.index',[
            'inventories' => $inventories,
            'categories' => $categories
        ]);
    }

    public function get_inventories(Request $request)
    {
        $data =  (new InventoryInventoryController)->index($request);
        return $data;
    }

    public function add_new()
    {
        $categories = Category::with('activeSubCategory')->where('status',1)->get();
        return view('admin.inventory.inventory.create', [
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'product_code' => 'required|unique:inventories,code,NULL,id,deleted_at,NULL',
                'product_name' => 'required',
                'category' => 'required',
                'selling_price' => 'required|numeric|between:0,9999999999.99',
                'sort_description' => 'required|min:50',
                'full_description' => 'required|min:50',
                'image' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventoryInventoryController)->create($request);

        return response()->json(['status'=>true,  'message'=>'New Inventory Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $inventory = Inventory::find($id);

        $categories = Category::with('activeSubCategory')->where('status',1)->get();

        return view('admin.inventory.inventory.update', [
            'categories' => $categories,
            'inventory' => $inventory
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(),
            [
                'product_code' => 'required|unique:inventories,code,'.$id.',id,deleted_at,NULL',
                'product_name' => 'required',
                'category' => 'required',
                'selling_price' => 'required|numeric|between:0,9999999999.99',
                'sort_description' => 'required|min:50',
                'full_description' => 'required|min:50'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventoryInventoryController)->update($request);

        return response()->json(['status'=>true,  'message'=>'Selected Inventory Updated Successfully']);
    }

    public function delete($id)
    {
        Sales::where('inv_id',$id)->delete();
        Inventory::destroy($id);
        return response()->json(['status'=>true,  'message'=>'Selected Inventory Deleted Successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);
        $inventory = Inventory::find($id);

        return view('admin.inventory.inventory.logs',[
            'inventory' => $inventory
        ]);
    }

    public function get_logs($id)
    {
        $category = InventoryLog::with(['getCreator'])->where('inv_id',$id)->orderBy('id','DESC');

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
