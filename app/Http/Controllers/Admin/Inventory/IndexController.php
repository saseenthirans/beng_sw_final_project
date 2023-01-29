<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Base\InventoryController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $data = (new InventoryController)->countAmount();

        return view('admin.inventory.index',[
            'data' => $data
        ]);
    }

    public function get_purchase()
    {
        $data = (new InventoryController)->purchaseChart();

        return response()->json(['data' =>$data]);
    }
}
