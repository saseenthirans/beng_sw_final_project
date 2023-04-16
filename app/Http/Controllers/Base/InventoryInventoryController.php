<?php

namespace App\Http\Controllers\Base;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Base\HelperController;
use App\Models\InventoryImage;
use App\Models\InventoryLog;

class InventoryInventoryController extends Controller
{
    public function index($request)
    {
        $query = Inventory::with(['category']);
                if(isset($request->category) && !empty($request->category))
                    $query = $query->where('category_id', $request->category);

                if(isset($request->qty) && !empty($request->qty))
                    $query = $query->where('qty', '<=' ,$request->qty);

        $inventory = $query->orderBy('id','DESC');
        $data =  Datatables::of($inventory)
            ->addIndexColumn()
            ->addColumn('image', function ($item) {
                $url = asset($item->image);

                if ($item->image == '') {
                    return '<img src="/adminstyle/assets/img/profile.jpg" border="0" width="50" class="stylist-image" align="center" />';
                }
                return '<img src="' . $url . '" border="0" width="50" class="stylist-image" align="center" />';
            })
            ->addColumn('status', function ($item) {
                if ($item->status == '0') {
                    return '<span class="badge badge-danger"> Inactive </span>';
                } else {
                    return '<span class="badge badge-success"> Active </span>';
                }
            })
            ->addColumn('name', function ($item) {
                return ucwords($item->name);
            })
            ->addColumn('category', function ($item) {
                return ucwords($item->category->name);
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/inventory/inventories/update/'.Crypt::encrypt($item->id));
                    $imageurl = url('admin/inventory/inventories/images/'.Crypt::encrypt($item->id));
                    $logurl = url('admin/inventory/inventories/logs/'.Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $imageurl . '" class="btn btn-sm btn-success editbtn square-btn" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation('. $item->id . ')" data-id="'. $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>
                    <a href="' . $logurl . '" class="btn btn-sm btn-secondary editbtn square-btn" title="View Logs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></a>';

                } else {
                    $editurl = url('admin/inventory/inventories/update/'.Crypt::encrypt($item->id));
                    $imageurl = url('admin/inventory/inventories/images/'.Crypt::encrypt($item->id));
                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $imageurl . '" class="btn btn-sm btn-success editbtn square-btn" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></a>';
                }

            })
            ->rawColumns(['status','image', 'action','name','category'])
            ->make(true);

        return $data;
    }

    public function create($request)
    {
        //Image
        if(isset($request->image) && $request->image->getClientOriginalName()){

            $image = (new HelperController)->fileUpload($request->image,'inv_' ,'inventory',800,900);
        }

        $inventory = new Inventory();
        $inventory->code = $request->product_code;
        $inventory->name = $request->product_name;
        $inventory->category_id = $request->category;
        $inventory->price = $request->selling_price;
        $inventory->description = $request->sort_description;
        $inventory->full_description = $request->full_description;
        $inventory->image = $image;
        $inventory->status = $request->status == true ? 1 : 0;
        $inventory->save();

        $inv_logs = new InventoryLog();
        $inv_logs->inv_id = $inventory->id;
        $inv_logs->work = 'Create Inventory';
        $inv_logs->user_id = Auth::user()->id;
        $inv_logs->save();

        $inv_image = new InventoryImage();
        $inv_image->inv_id =  $inventory->id;
        $inv_image->image = $image;
        $inv_image->save();

        return true;
    }

    public function update($request)
    {
        $inventory = Inventory::find($request->id);
        //Image
        if(isset($request->image) && $request->image->getClientOriginalName()){

            $image = (new HelperController)->fileUpload($request->image,'inv_' ,'inventory',800,900);
        }
        else
        {
            if (!$inventory->image)
                $image = '';
            else
                $image = $inventory->image;
        }

        $inventory->code = $request->product_code;
        $inventory->name = $request->product_name;
        $inventory->category_id = $request->category;
        $inventory->price = $request->selling_price;
        $inventory->description = $request->sort_description;
        $inventory->full_description = $request->full_description;
        $inventory->image = $image;
        $inventory->status = $request->status == true ? 1 : 0;
        $inventory->update();

        $inv_logs = new InventoryLog();
        $inv_logs->inv_id = $inventory->id;
        $inv_logs->work = 'Update Inventory';
        $inv_logs->user_id = Auth::user()->id;
        $inv_logs->save();

        return true;
    }
}
