<?php

namespace App\Http\Controllers\Base;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\PurchaseItem;
use App\Models\PurchasePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class InventoryPurchaseController extends Controller
{
    public function index($request)
    {
        $query = Purchase::with(['supplier']);

                if(isset($request->supplier) && !empty($request->supplier))
                    $query = $query->where('supplier_id', $request->supplier);

                if(isset($request->status) && !empty($request->status))
                    $query = $query->where('status', $request->status);

        $purchases = $query->orderBy('id','DESC');

        $data =  Datatables::of($purchases)
            ->addIndexColumn()

            ->addColumn('status', function ($item) {
                if ($item->status == '0') {
                    return '<span class="badge badge-danger"> Unsettled </span>';
                } else {
                    return '<span class="badge badge-success"> Settled </span>';
                }
            })
            ->addColumn('supplier', function ($item) {
                return ucwords($item->supplier->name);
            })
            ->addColumn('inv_file', function ($item) {
                if ($item->inv_file != '') {
                    $url = asset($item->inv_file);
                    return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>';
                } else {
                    return '';
                }
            })
            ->addColumn('final_amount', function ($item) {
                return number_format(($item->pur_amount - $item->discount),2);
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/inventory/purchases/update/'.Crypt::encrypt($item->id));
                    $logurl = url('admin/inventory/purchases/logs/'.Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation('. $item->id . ')" data-id="'. $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>
                    <a href="' . $logurl . '" class="btn btn-sm btn-secondary editbtn square-btn" title="View Logs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></a>';

                } else {
                    $editurl = url('staff/inventory/purchases/update/'.Crypt::encrypt($item->id));
                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>';
                }

            })
            ->rawColumns(['status', 'supplier','inv_file','final_amount', 'action'])
            ->make(true);

        return $data;
    }

    public function create($request)
    {
        $invoice_doc = '';
        if(isset($request->invoice_doc) && $request->invoice_doc->getClientOriginalName()){

            $invoice_doc = (new HelperController)->fileUpload2($request->invoice_doc,'pur_' ,'purchase');
        }

        $purchase = new Purchase();
        $purchase->invoice = $request->invoice_number;
        $purchase->supplier_id = $request->supplier;
        $purchase->pur_date = $request->purchased_date;
        $purchase->pur_amount = 0;
        $purchase->discount = isset($request->discount) && !empty($request->discount) ? $request->discount : 0;
        $purchase->inv_file = $invoice_doc;
        $purchase->save();

        if (isset($request->product_id) && !empty($request->product_id)) {
            $product_id = $request->product_id;
            $qty = $request->qty;
            $price = $request->price;

            $amount = 0;
            for ($i = 0; $i < count($product_id); $i++) {

                $amount = $amount + ($price[$i] * $qty[$i]);

                $item = new PurchaseItem();
                $item->pur_id = $purchase->id;
                $item->product_id = $product_id[$i];
                $item->qty = $qty[$i];
                $item->unit_price = $price[$i];
                $item->amount = $price[$i] * $qty[$i];
                $item->save();

                //Update or Store Factory Inventory

                $inventory = Inventory::find($product_id[$i]);

                if ($inventory) {
                    $inventory->qty = $inventory->qty + $qty[$i];
                    $inventory->update();
                }
            }

            //Update the Existing Purchase Total Amount
            $purchaseExist = Purchase::find($purchase->id);
            $purchaseExist->pur_amount = $purchaseExist->pur_amount + $amount;
            $purchaseExist->update();
        }

        if ($request->is_paid == true) {
            $payment = new PurchasePayment();
            $payment->pur_id = $purchase->id;
            $payment->pay_type = $request->pay_method;
            $payment->amount = $request->paid_amount;
            $payment->paid_date = $request->paid_date;
            $payment->save();
        }

        return true;
    }
}
