<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventoryInventoryImageController;
use App\Models\InventoryImage;

class InventoryImageController extends Controller
{
    public function index($id)
    {
        $id = Crypt::decrypt($id);
        $inventory = Inventory::find($id);

        return view('admin.inventory.inventory.images',[
            'inventory' => $inventory
        ]);
    }

    public function get_images($id)
    {
        $data = (new InventoryInventoryImageController)->index($id);

        return $data;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'image' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'statuscode'=>400, 'errors'=>$validator->errors()]);
        }

        $create = (new InventoryInventoryImageController)->create($request);

        return response()->json(['status'=>true,  'message'=>'New Inventory Image Created Successfully']);
    }

    public function delete($id)
    {
        InventoryImage::destroy($id);
        return response()->json(['status'=>true,  'message'=>'Selected Inventory Image deleted Successfully']);
    }
}
