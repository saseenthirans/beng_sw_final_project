<?php

namespace App\Http\Controllers\Base\RepairItem;

use App\Models\Inventory;
use App\Models\Repairing;
use App\Models\RepairingLog;
use Illuminate\Http\Request;
use App\Models\RepairingItem;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Base\HelperController;

class RepairingController extends Controller
{
    public function index($request)
    {
        $query = Repairing::with(['customer', 'category', 'creator']);

        if (isset($request->category) && !empty($request->category))
            $query = $query->where('category_id', $request->category);

        if (isset($request->start_date) && !empty($request->start_date))
            $query = $query->whereDate('taken_date', '>=', $request->start_date);

        if (isset($request->end_date) && !empty($request->end_date))
            $query = $query->whereDate('taken_date', '<=', $request->end_date);

        $repairings = $query->orderBy('id', 'DESC');

        $data =  Datatables::of($repairings)
            ->addIndexColumn()

            ->addColumn('status', function ($item) {
                if ($item->status == '0') {
                    return '<span class="badge badge-danger"> Token </span>';
                }

                if ($item->status == '1') {
                    return '<span class="badge badge-warning"> Processing </span>';
                }

                if ($item->status == '2') {
                    return '<span class="badge badge-warning"> Ready to Collect </span>';
                }

                if ($item->status == '3') {
                    return '<span class="badge badge-success"> Collect </span>';
                }
            })
            ->addColumn('paid_status', function ($item) {
                if ($item->paid_status == '0') {
                    return '<span class="badge badge-danger"> Not Paid </span>';
                }

                if ($item->paid_status == '1') {
                    return '<span class="badge badge-warning"> Advance Paid </span>';
                }

                if ($item->paid_status == '2') {
                    return '<span class="badge badge-success"> Fully Paid </span>';
                }
            })
            ->addColumn('customer', function ($item) {
                return ucwords($item->customer->name);
            })
            ->addColumn('created_by', function ($item) {
                return ucwords($item->creator->name);
            })
            ->addColumn('due_amount', function ($item) {
                $due_amount = $item->amount - $item->adv_amount;

                return number_format($due_amount, 2, '.', '');
            })
            ->addColumn('collect_at', function ($item) {

                $collect_at = '';
                if ($item->status == 3) {
                    $collect_at = date('Y-m-d', strtotime($item->updated_at));
                }

                return $collect_at;
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/repair_items/repairing/update/' . Crypt::encrypt($item->id));
                    $download_url = url('admin/repair_items/repairing/download/' . Crypt::encrypt($item->id));
                    $logurl = url('admin/repair_items/repairing/logs/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $download_url . '" class="btn btn-sm btn-dark editbtn square-btn" title="Download"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                   <a href="#" class="btn btn-sm btn-danger deletebtn square-btn"  title="Delete" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>
                    <a href="' . $logurl . '" class="btn btn-sm btn-secondary editbtn square-btn" title="View Logs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></a>';
                } else {
                    $editurl = url('admin/repair_items/repairing/update/' . Crypt::encrypt($item->id));
                    $download_url = url('admin/repair_items/repairing/download/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $download_url . '" class="btn btn-sm btn-dark editbtn square-btn" title="Download"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>';
                }
            })
            ->rawColumns(['status', 'customer', 'created_by', 'paid_status', 'due_amount', 'action', 'created_at', 'collect_at'])
            ->make(true);

        return $data;
    }

    public function create($request)
    {
        //Fully Paid
        if ($request->paid_amount == $request->sub_total) {
            $paid_status = 2;
        }

        //Advance Paid
        if ($request->paid_amount < $request->sub_total) {
            $paid_status = 1;
        }

        //Not Paid
        if ($request->paid_amount == 0) {
            $paid_status = 0;
        }

        $repairing = new Repairing();
        $repairing->ref_no = date('Ymdhis');
        $repairing->title = $request->title;
        $repairing->customer_id = $request->customer;
        $repairing->user_id = Auth::user()->id;
        $repairing->category_id = $request->category;
        $repairing->taken_date = $request->date;
        $repairing->charge = $request->service_charge;
        $repairing->note = $request->note;
        $repairing->amount = $request->sub_total;
        $repairing->adv_amount = $request->paid_amount;
        $repairing->status = 0; //0 - Taken | 1 - Processing | 2 - Ready Collect | 3 - Collected
        $repairing->paid_status = $paid_status;
        $repairing->save();

        //Store the Invoice Items
        if (isset($request->product_id) && !empty($request->product_id)) {

            $product_id = $request->product_id;
            $qty = $request->qty;
            $price = $request->price;

            for ($i = 0; $i < count($product_id); $i++) {
                $inventory = Inventory::find($product_id[$i]);

                if ($inventory) {

                    //Insert the Repairing Items
                    $item = new RepairingItem();
                    $item->repairing_id = $repairing->id;
                    $item->product_id = $inventory->id;
                    $item->qty = $qty[$i];
                    $item->amount = $price[$i];
                    $item->total = $price[$i] * $qty[$i];
                    $item->save();

                    //Update the Inventory
                    $qty_inv = $inventory->qty;
                    $detect_qty = $qty_inv - $qty[$i];

                    if ($detect_qty > 0) {
                        $inventory->qty = $inventory->qty - $qty[$i];
                    } else {
                        $inventory->qty = 0;
                    }
                    $inventory->update();
                }
            }
        }

        //Store the Repairing Log
        $logs = new RepairingLog();
        $logs->repairing_id = $repairing->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Create Repairing Details';
        $logs->save();

        (new HelperController)->repairSMS($repairing);
    }

    public function addRepairItem($request, $repairing)
    {
        $product_id = $request->product;
        $qty = $request->qty;
        $price = $request->price;

        $inventory = Inventory::find($product_id);

        if ($inventory) {

            //Insert the Invoice Items
            $item = new RepairingItem();
            $item->repairing_id = $repairing->id;
            $item->product_id = $inventory->id;
            $item->qty = $qty;
            $item->amount = $price;
            $item->total = $price * $qty;
            $item->save();

            //Update the Inventory
            $qty_inv = $inventory->qty;
            $detect_qty = $qty_inv - $qty;

            if ($detect_qty > 0) {
                $inventory->qty = $inventory->qty - $qty;
            } else {
                $inventory->qty = 0;
            }
            $inventory->update();

            //Store the Invoice Log
            $logs = new RepairingLog();
            $logs->repairing_id = $repairing->id;
            $logs->user_id = Auth::user()->id;
            $logs->work = 'Add New Repair Item - ' . $inventory->code . ' - ' . $inventory->name;
            $logs->save();

            //Update Repairing Data
            $sub_toal = $repairing->repairItems->sum('total');

            $repairing->amount = $sub_toal + $repairing->charge;
            $repairing->update();
        }
    }

    public function deleteItems($request)
    {
        $id = $request->id;
        $item = RepairingItem::find($id);

        $repairing_id = $item->repairing_id;
        $product_id = $item->product_id;
        $qty = $item->qty;
        $price = $item->amount;

        $inventory = Inventory::find($product_id);
        $repairing = Repairing::find($repairing_id);

        if ($inventory) {

            //Update the Inventory
            $inventory->qty = $inventory->qty + $qty;
            $inventory->update();

            //Store the Invoice Log
            $logs = new RepairingLog();
            $logs->repairing_id = $repairing_id;
            $logs->user_id = Auth::user()->id;
            $logs->work = 'Delete Repairing Item - '.$inventory->code .' - '. $inventory->name;
            $logs->save();

             //Update Repairing Data
            $sub_toal = $repairing->repairItems->sum('total');

            $repairing->amount = $sub_toal + $repairing->charge;
            $repairing->update();

            //Delete the Repairing Item
            RepairingItem::destroy($id);
        }
    }

    public function update($request)
    {
        //Fully Paid
        if ($request->paid_amount == $request->sub_total) {
            $paid_status = 2;
        }

        //Advance Paid
        if ($request->paid_amount < $request->sub_total) {
            $paid_status = 1;
        }

        //Not Paid
        if ($request->paid_amount == 0) {
            $paid_status = 0;
        }

        $repairing = Repairing::find($request->id);
        $repairing->title = $request->title;
        $repairing->customer_id = $request->customer;
        $repairing->user_id = Auth::user()->id;
        $repairing->category_id = $request->category;
        $repairing->taken_date = $request->date;
        $repairing->charge = $request->service_charge;
        $repairing->note = $request->note;
        $repairing->amount = $request->sub_total;
        $repairing->adv_amount = $request->paid_amount;
        $repairing->status = $request->status; //0 - Taken | 1 - Processing | 2 - Ready Collect | 3 - Collected
        $repairing->paid_status = $paid_status;
        $repairing->collect_before = (isset($request->collect_before) && !empty($request->collect_before)) ? $request->collect_before : NULL;
        $repairing->collected_at = $request->status == 3 ? date('Y-m-d') : NULL;
        $repairing->update();

        //Store the Repairing Log
        $logs = new RepairingLog();
        $logs->repairing_id = $repairing->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Repairing Update Details';
        $logs->save();

        (new HelperController)->repairSMS($repairing);
    }

    public function repairingExport($request)
    {
        $query = Repairing::with(['customer', 'category', 'creator']);

        if (isset($request->category) && !empty($request->category))
            $query = $query->where('category_id', $request->category);

        if (isset($request->start_date) && !empty($request->start_date))
            $query = $query->whereDate('taken_date', '>=', $request->start_date);

        if (isset($request->end_date) && !empty($request->end_date))
            $query = $query->whereDate('taken_date', '<=', $request->end_date);

        $repairings = $query->orderBy('id', 'DESC')->get();

        return $repairings;
    }
}
