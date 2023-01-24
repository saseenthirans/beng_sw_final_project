<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Base\InventoryPurchaseController;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
        return view('admin.inventory.purchase.create');
    }
}
