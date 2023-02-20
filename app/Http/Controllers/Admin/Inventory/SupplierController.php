<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventorySupplierController;
use Illuminate\Support\Facades\Crypt;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('admin.inventory.supplier.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function get_suppliers(Request $request)
    {
        $data =  (new InventorySupplierController)->index($request);
        return $data;
    }

    public function add_new()
    {
        return view('admin.inventory.supplier.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'supplier_name' => 'required',
                'address' => 'required',
                'contact' => 'required|digits:10|unique:suppliers,contact,NULL,id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:suppliers,email,NULL,id,deleted_at,NULL',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $supplier = new Supplier();
        $supplier->name = $request->supplier_name;
        $supplier->address = $request->address;
        $supplier->contact = $request->contact;
        $supplier->email = $request->email;
        $supplier->status = $request->status == true ? 1 : 0;
        $supplier->save();

        return response()->json(['status' => true,  'message' => 'New Supplier Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);

        $supplier = Supplier::find($id);

        return view('admin.inventory.supplier.update', [
            'supplier' => $supplier
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make(
            $request->all(),
            [
                'supplier_name' => 'required',
                'address' => 'required',
                'contact' => 'required|digits:10|unique:suppliers,contact,' . $id . ',id,deleted_at,NULL',
                'email' => 'required|email:rfc,dns|unique:suppliers,email,' . $id . ',id,deleted_at,NULL',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $supplier = Supplier::find($id);
        $supplier->name = $request->supplier_name;
        $supplier->address = $request->address;
        $supplier->contact = $request->contact;
        $supplier->email = $request->email;
        $supplier->status = $request->status == true ? 1 : 0;
        $supplier->update();

        return response()->json(['status' => true,  'message' => 'Selected Supplier Updated Successfully']);
    }

    public function delete($id)
    {
        Supplier::destroy($id);

        return response()->json(['status' => true,  'message' => 'Selected Supplier Deleted Successfully']);
    }
}
