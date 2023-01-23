<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Sales;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::all();

        return view('admin.inventory.sales.index', [
            'sales' => $sales
        ]);
    }

    public function get_sales()
    {
        $sales = Sales::with('inventory')->orderBy('id', 'DESC');

        $data =  Datatables::of($sales)
            ->addIndexColumn()

            ->addColumn('code', function ($item) {
                return $item->inventory->code;
            })
            ->addColumn('product', function ($item) {
                return $item->inventory->name;
            })
            ->addColumn('sale_type', function ($item) {
                if ($item->sale_type == 1) {
                    return 'Percentage';
                } else {
                    return 'Amount';
                }
            })
            ->addColumn('amount', function ($item) {
                if ($item->sale_type == 1) {
                    return $item->amount.'%';
                } else {
                    return $item->amount;
                }
            })
            ->addColumn('sale_value', function ($item) {
                if ($item->sale_type == 1) {
                    $sale_value = $item->inventory->price - (($item->inventory->price * $item->amount)/100);
                    return number_format($sale_value,2);
                } else {
                    $sale_value = $item->inventory->price - $item->amount;
                    return number_format($sale_value,2);
                }
            })
            ->addColumn('start_end_date', function ($item) {
                return $item->start_date .' - '.$item->end_date;
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return '<span class="badge badge-danger">Inactive</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })

            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/inventory/sales/update/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';
                }
            })
            ->rawColumns(['code','product','sale_type','amount', 'status', 'sale_value','start_end_date','action'])
            ->make(true);

        return $data;
    }

    public function add_new()
    {
        $inventory = Inventory::where('status', 1)->get();

        return view('admin.inventory.sales.create', [
            'inventory' => $inventory
        ]);
    }

    public function getprice(Request $request)
    {
        $inventory = Inventory::find($request->id);

        return response()->json(['inventory' => $inventory]);
    }

    public function create(Request $request)
    {
        if ($request->sale_type == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required',
                    'sale_type' => 'required',
                    'amount' => 'required|numeric|min:1|max:100',
                    'end_date' => 'required',
                    'start_date' => 'required',
                ]
            );
        }
        else
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required',
                    'sale_type' => 'required',
                    'amount' => 'required|numeric|between:0,9999999999.99',
                    'end_date' => 'required',
                    'start_date' => 'required',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $exist = Sales::where('inv_id',$request->product_id)->whereDate('end_date','>=', $request->start_date)->count();

        if ($exist > 0) {
            return response()->json(['status' => false, 'message' => 'This Product Already in sale']);
        }

        $sales = new Sales();
        $sales->inv_id = $request->product_id;
        $sales->sale_type = $request->sale_type;
        $sales->amount = $request->amount;
        $sales->start_date = $request->start_date;
        $sales->end_date = $request->end_date;
        $sales->save();

        return response()->json(['status'=>true, 'message'=>'New Sales Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $sale = Sales::find($id);
        $inventory = Inventory::where('status', 1)->get();

        return view('admin.inventory.sales.update', [
            'inventory' => $inventory,
            'sale' => $sale
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        if ($request->sale_type == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required',
                    'sale_type' => 'required',
                    'amount' => 'required|numeric|min:1|max:100',
                    'end_date' => 'required',
                    'start_date' => 'required',
                ]
            );
        }
        else
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required',
                    'sale_type' => 'required',
                    'amount' => 'required|numeric|between:0,9999999999.99',
                    'end_date' => 'required',
                    'start_date' => 'required',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $exist = Sales::where('inv_id',$request->product_id)->whereDate('end_date','>=', $request->start_date)->where('id','!=',$id)->count();

        if ($exist > 0) {
            return response()->json(['status' => false, 'message' => 'This Product Already in sale']);
        }

        $sales = Sales::find($id);
        $sales->inv_id = $request->product_id;
        $sales->sale_type = $request->sale_type;
        $sales->amount = $request->amount;
        $sales->start_date = $request->start_date;
        $sales->end_date = $request->end_date;
        $sales->update();

        return response()->json(['status'=>true, 'message'=>'Selected Sales Updated Successfully']);
    }

    public function delete($id)
    {
        Sales::destroy($id);
        return response()->json(['status'=>true, 'message'=>'Selected Sales Deleted Successfully']);
    }
}
