<?php

namespace App\Http\Controllers\Base;

use App\Models\InventoryLog;
use Illuminate\Http\Request;
use App\Models\InventoryImage;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Base\HelperController;

class InventoryInventoryImageController extends Controller
{
    public function index($id)
    {
        $images = InventoryImage::where('inv_id',$id)->orderBy('id','DESC');

        $data =  Datatables::of($images)
            ->addIndexColumn()
            ->addColumn('image', function ($item) {
                $url = asset($item->image);

                if ($item->image == '') {
                    return '<img src="/adminstyle/assets/img/profile.jpg" border="0" width="50" class="stylist-image" align="center" />';
                }
                return '<img src="' . $url . '" border="0" width="50" class="stylist-image" align="center" />';
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    return '<a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation('. $item->id . ')" data-id="'. $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';

                }
            })
            ->rawColumns(['image', 'action'])
            ->make(true);

        return $data;
    }

    public function create(Request $request)
    {
        if(isset($request->image) && $request->image->getClientOriginalName()){

            $image = (new HelperController)->fileUpload($request->image,'inv_' ,'inventory',800,900);
        }

        $inv_image = new InventoryImage();
        $inv_image->inv_id = $request->id;
        $inv_image->image = $image;
        $inv_image->save();

        $inv_logs = new InventoryLog();
        $inv_logs->inv_id = $request->id;
        $inv_logs->work = 'Create Image';
        $inv_logs->user_id = Auth::user()->id;
        $inv_logs->save();

        return true;
    }
}
