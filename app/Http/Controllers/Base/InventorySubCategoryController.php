<?php

namespace App\Http\Controllers\Base;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\SubCategoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class InventorySubCategoryController extends Controller
{
    public function index($request)
    {
        $query = SubCategory::with(['getCreator','getCategory']);

                if(isset($request->category) && !empty($request->category))
                    $query = $query->where('category_id', $request->category);

        $category = $query->orderBy('id','DESC');

        $data =  Datatables::of($category)
            ->addIndexColumn()

            ->addColumn('status', function ($item) {
                if ($item->status == '0') {
                    return '<span class="badge badge-danger"> Inactive </span>';
                } else {
                    return '<span class="badge badge-success"> Active </span>';
                }
            })
            ->addColumn('category', function ($item) {
                return ucwords($item->getCategory->name);
            })
            ->addColumn('created', function ($item) {
                return ucwords($item->getCreator->name);
            })
            ->addColumn('name', function ($item) {
                return ucwords($item->name);
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/inventory/subcategories/update/'.Crypt::encrypt($item->id));
                    $logurl = url('admin/inventory/subcategories/logs/'.Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation('. $item->id . ')" data-id="'. $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>
                    <a href="' . $logurl . '" class="btn btn-sm btn-secondary editbtn square-btn" title="View Logs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></a>';

                } else {
                    $editurl = url('admin/inventory/subcategories/update/'.Crypt::encrypt($item->id));
                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>';
                }

            })
            ->rawColumns(['status', 'category','created', 'action','name'])
            ->make(true);

        return $data;
    }

    public function create($request)
    {
        $category = new SubCategory();
        $category->category_id = $request->category;
        $category->name = $request->sub_category_name;
        $category->status = $request->status == true ? 1 : 0;
        $category->user_id = Auth::user()->id;
        $category->save();

        $category_log = new SubCategoryLog();
        $category_log->sub_category_id = $category->id;
        $category_log->user_id = Auth::user()->id;
        $category_log->save();

        return true;
    }

    public function update($request)
    {
        $category = SubCategory::find($request->id);
        $category->category_id = $request->category;
        $category->name = $request->sub_category_name;
        $category->status = $request->status == true ? 1 : 0;
        $category->user_id = Auth::user()->id;
        $category->update();

        $category_log = new SubCategoryLog();
        $category_log->sub_category_id = $category->id;
        $category_log->user_id = Auth::user()->id;
        $category_log->save();

        return true;
    }
}
