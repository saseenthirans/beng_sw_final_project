<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventoryPurchaseController;
use App\Models\PaymentMethod;

class PurchaseController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where('status',1)->get();

        return view('admin.inventory.purchase.index', [
            'suppliers' =>$suppliers
        ]);
    }

    public function get_purchases(Request $request)
    {
        $data = (new InventoryPurchaseController)->index($request);

        return $data;
    }

    public function add_new()
    {
        $suppliers = Supplier::where('status',1)->get();
        $inventory = Inventory::all();
        $paymethod = PaymentMethod::all();

        return view('admin.inventory.purchase.create',[
            'suppliers' => $suppliers,
            'inventory' => $inventory,
            'paymethod' => $paymethod
        ]);
    }

    public function product_validation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product' => 'required',
                'qty' => 'required|numeric',
                'price' => 'required|numeric|between:0,9999999999.99'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false,  'errors' => $validator->errors()]);
        }

        $product = Inventory::find($request->product);

        return response()->json(['status' => true, 'data' => [
            'product_id' => $product->id,
            'product_name' => $product->code . ' - ' . $product->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'price_' => number_format($request->price,2),
            'total' => $request->qty * $request->price,
            'total_' => number_format(($request->qty * $request->price),2)
        ]]);
    }
}
