<?php

namespace App\Http\Controllers\Base\Invoice;

use PDF;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Inventory;
use App\Models\InvoiceLog;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\InvoicePayment;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Base\HelperController;

class InvoiceController extends Controller
{
    public function index($request)
    {
        $query = Invoice::with(['customers', 'creator', 'invoiceItems', 'invoicePayment']);

        if (isset($request->customer) && !empty($request->customer))
            $query = $query->where('customer_id', $request->customer);

        if (isset($request->start_date) && !empty($request->start_date))
            $query = $query->whereDate('invoice_date', '>=', $request->start_date);

        if (isset($request->end_date) && !empty($request->end_date))
            $query = $query->whereDate('invoice_date', '<=', $request->end_date);

        $invoices = $query->orderBy('id', 'DESC');

        $data =  Datatables::of($invoices)
            ->addIndexColumn()

            ->addColumn('status', function ($item) {
                if ($item->status == '0') {
                    return '<span class="badge badge-danger"> Unsettled </span>';
                } else {
                    return '<span class="badge badge-success"> Settled </span>';
                }
            })
            ->addColumn('customer', function ($item) {
                return ucwords($item->customers->name);
            })
            ->addColumn('created_by', function ($item) {
                return ucwords($item->creator->name);
            })
            ->addColumn('discount', function ($item) {
                return round($item->disc_percentage, 2);
            })
            ->addColumn('due_amount', function ($item) {
                $payment = $item->invoicePayment->sum('amount');
                $due_amount = $item->total - $payment;

                return number_format($due_amount, 2, '.', '');
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $editurl = url('admin/invoices/invoices/update/' . Crypt::encrypt($item->id));
                    $paid_url = url('admin/invoices/invoices/payments/' . Crypt::encrypt($item->id));
                    $download_url = url('admin/invoices/invoices/download/' . Crypt::encrypt($item->id));
                    $send_invoice = url('admin/invoices/invoices/mail/' . Crypt::encrypt($item->id));
                    $logurl = url('admin/invoices/invoices/logs/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $paid_url . '" class="btn btn-sm btn-success editbtn square-btn" title="Payments"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></a>
                    <a href="' . $download_url . '" class="btn btn-sm btn-dark editbtn square-btn" title="Download"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                    <a href="' . $send_invoice . '" class="btn btn-sm btn-warning editbtn square-btn" title="Send Mail Copy"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></a>
                    <a href="#" class="btn btn-sm btn-danger deletebtn square-btn"  title="Delete" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>
                    <a href="' . $logurl . '" class="btn btn-sm btn-secondary editbtn square-btn" title="View Logs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></a>';
                } else {
                    $editurl = url('admin/invoices/invoices/update/' . Crypt::encrypt($item->id));
                    $paid_url = url('admin/invoices/invoices/payments/' . Crypt::encrypt($item->id));
                    $download_url = url('admin/invoices/invoices/download/' . Crypt::encrypt($item->id));
                    $send_invoice = url('admin/invoices/invoices/mail/' . Crypt::encrypt($item->id));

                    return '<a href="' . $editurl . '" class="btn btn-sm btn-primary editbtn square-btn" title="Edit"><svg id="edit_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_783" data-name="Path 783" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_784" data-name="Path 784" d="M3,12.445v1.986a.323.323,0,0,0,.327.327H5.312a.306.306,0,0,0,.229-.1l7.133-7.127-2.45-2.45L3.1,12.21a.321.321,0,0,0-.1.235ZM14.569,5.638a.651.651,0,0,0,0-.921L13.04,3.189a.651.651,0,0,0-.921,0l-1.2,1.2,2.45,2.45,1.2-1.2Z" transform="translate(-1.04 -1.039)" fill="#fff"/></svg></a>
                    <a href="' . $paid_url . '" class="btn btn-sm btn-success editbtn square-btn" title="Payments"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></a>
                    <a href="' . $download_url . '" class="btn btn-sm btn-dark editbtn square-btn" title="Download"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                    <a href="' . $send_invoice . '" class="btn btn-sm btn-warning editbtn square-btn" title="Send Mail Copy"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></a>';
                }
            })
            ->rawColumns(['status', 'customer', 'created_by', 'discount', 'due_amount', 'action'])
            ->make(true);

        return $data;
    }

    public function create($request)
    {
        $discount = (($request->sub_total * $request->discount) / 100);

        $invoice = new Invoice();
        $invoice->ref_no = date('YmdHis');
        $invoice->customer_id = $request->customer;
        $invoice->user_id = Auth::user()->id;
        $invoice->invoice_date = $request->date;
        $invoice->sub_total = $request->sub_total;
        $invoice->tax_amount = $request->tax_amount;
        $invoice->disc_percentage = $request->discount;
        $invoice->disc_amount = $discount;
        $invoice->total = $request->total_amount;
        $invoice->status = $request->due_amount == "0.00" ? 1 : 0;
        $invoice->save();

        //Store the Invoice Items
        if (isset($request->product_id) && !empty($request->product_id)) {

            $product_id = $request->product_id;
            $qty = $request->qty;
            $price = $request->price;

            for ($i = 0; $i < count($product_id); $i++) {
                $inventory = Inventory::find($product_id[$i]);

                if ($inventory) {

                    //Insert the Invoice Items
                    $item = new InvoiceItem();
                    $item->invoice_id = $invoice->id;
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

        //Store Payment Hisotry
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoice->id;
        $payment->pay_type = $request->pay_type;
        $payment->amount = ($request->total_amount - $request->due_amount);
        $payment->paid_date = date('Y-m-d');
        $payment->save();

        //Store the Invoice Log
        $logs = new InvoiceLog();
        $logs->inv_id = $invoice->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Create Invoice';
        $logs->save();
    }

    public function addInvoiceItem($request, $invoice)
    {
        $product_id = $request->product;
        $qty = $request->qty;
        $price = $request->price;

        $inventory = Inventory::find($product_id);

        if ($inventory) {

            //Insert the Invoice Items
            $item = new InvoiceItem();
            $item->invoice_id = $invoice->id;
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
            $logs = new InvoiceLog();
            $logs->inv_id = $invoice->id;
            $logs->user_id = Auth::user()->id;
            $logs->work = 'Add New Invoice Item - '.$inventory->code .' - '. $inventory->name;
            $logs->save();

            //Update Invoice Data
            $sub_toal = $invoice->invoiceItems->sum('total');
            $discount = (($sub_toal * $invoice->disc_percentage) / 100);

            $invoice->sub_total = $sub_toal;
            $invoice->disc_amount = $discount;
            $invoice->total = $sub_toal - $discount;
            $invoice->update();
        }
    }

    public function deleteInvoiceItem($request)
    {
        $id = $request->id;
        $item = InvoiceItem::find($id);

        $invoice_id = $item->invoice_id;
        $product_id = $item->product_id;
        $qty = $item->qty;
        $price = $item->amount;

        $inventory = Inventory::find($product_id);
        $invoice = Invoice::find($invoice_id);

        if ($inventory) {

            //Update the Inventory
            $inventory->qty = $inventory->qty + $qty;
            $inventory->update();

            //Store the Invoice Log
            $logs = new InvoiceLog();
            $logs->inv_id = $invoice->id;
            $logs->user_id = Auth::user()->id;
            $logs->work = 'Delete Invoice Item - '.$inventory->code .' - '. $inventory->name;
            $logs->save();

            //Update Invoice Data
            $sub_toal = $invoice->invoiceItems->sum('total');
            $discount = (($sub_toal * $invoice->disc_percentage) / 100);

            $invoice->sub_total = $sub_toal;
            $invoice->disc_amount = $discount;
            $invoice->total = $sub_toal - $discount;
            $invoice->update();

            //Delete the Invoice Item
            InvoiceItem::destroy($id);
        }
    }

    public function update($request)
    {
        $discount = (($request->sub_total * $request->discount) / 100);

        $invoice = Invoice::find($request->id);
        $invoice->customer_id = $request->customer;
        $invoice->invoice_date = $request->date;
        $invoice->sub_total = $request->sub_total;
        $invoice->tax_amount = $request->tax_amount;
        $invoice->disc_percentage = $request->discount;
        $invoice->disc_amount = $discount;
        $invoice->total = $request->total_amount;
        $invoice->status = $request->due_amount == "0.00" ? 1 : 0;
        $invoice->update();

        //Store Payment Hisotry
        $payment = $invoice->firstPayment();
        $payment->invoice_id = $invoice->id;
        $payment->pay_type = $request->pay_type;
        $payment->amount = ($request->total_amount - $request->due_amount);
        $payment->paid_date = date('Y-m-d');
        $payment->update();

        //Store the Invoice Log
        $logs = new InvoiceLog();
        $logs->inv_id = $invoice->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Update the Invoice';
        $logs->save();
    }

    public function get_payments($id)
    {
        $payments = InvoicePayment::where('invoice_id', $id)->orderBy('id', 'DESC');

        $data =  Datatables::of($payments)
            ->addIndexColumn()

            ->addColumn('paymethod', function ($item) {
                return ucwords($item->payMethod->method);
            })
            ->addColumn('paid_date', function ($item) {
                return date('Y-m-d', strtotime($item->paid_date));
            })
            ->addColumn('action', function ($item) {

                if (Auth::user()->hasRole('Admin')) {

                    $invoice = Invoice::find($item->invoice_id);

                    if ($item->id != $invoice->firstPayment()->id) {
                        return '<a href="#" class="btn btn-sm btn-danger deletebtn square-btn" onclick="deleteConfirmation(' . $item->id . ')" data-id="' . $item->id . '"><svg id="delete_black_24dp" xmlns="http://www.w3.org/2000/svg" width="15.678" height="15.678" viewBox="0 0 15.678 15.678"><path id="Path_781" data-name="Path 781" d="M0,0H15.678V15.678H0Z" fill="none"/><path id="Path_782" data-name="Path 782" d="M5.653,13.452A1.31,1.31,0,0,0,6.96,14.758h5.226a1.31,1.31,0,0,0,1.306-1.306V6.919a1.31,1.31,0,0,0-1.306-1.306H6.96A1.31,1.31,0,0,0,5.653,6.919Zm7.839-9.8H11.859L11.4,3.189A.659.659,0,0,0,10.938,3H8.207a.659.659,0,0,0-.457.189l-.464.464H5.653a.653.653,0,0,0,0,1.306h7.839a.653.653,0,1,0,0-1.306Z" transform="translate(-1.734 -1.04)" fill="#fff"/></svg></a>';
                    }

                }
            })
            ->rawColumns(['paymethod', 'paid_date', 'action'])
            ->make(true);

        return $data;
    }

    public function store_payments($request)
    {
        $invoice = Invoice::find($request->inv_id);

        //Store Invoice Payment
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoice->id;
        $payment->pay_type = $request->pay_method;
        $payment->amount = $request->paid_amount;
        $payment->paid_date = $request->paid_date;
        $payment->save();

        //Update the Invoice Status
        $invoice->status = $request->due_amount == "0.00" ? 1 : 0; //Check the Due Amount equal to "0" or Not
        $invoice->update();

        //Store the Invoice Log
        $logs = new InvoiceLog();
        $logs->inv_id = $invoice->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Add New payment';
        $logs->save();

    }

    public function invoiceExport($request)
    {
        $query = Invoice::with(['customers', 'creator', 'invoiceItems', 'invoicePayment']);

        if (isset($request->customer) && !empty($request->customer))
            $query = $query->where('customer_id', $request->customer);

        if (isset($request->start_date) && !empty($request->start_date))
            $query = $query->whereDate('invoice_date', '>=', $request->start_date);

        if (isset($request->end_date) && !empty($request->end_date))
            $query = $query->whereDate('invoice_date', '<=', $request->end_date);

        $invoices = $query->orderBy('id', 'DESC')->get();

        return $invoices;
    }

    public function send_mail($id)
    {
        $id = Crypt::decrypt($id);

        $invoice = Invoice::find($id);
        $company = Company::find(1);

        $pdfdata = [
            'invoice' => $invoice,
            'company' =>$company,
            'url' => url($company->image)
        ];

        $pdf = PDF::loadView('download.invoice', $pdfdata);
        $pdf_name = $invoice->ref_no.'.pdf';

        //Email Sending
            $maildata["email"] = $invoice->customers->email;
            $maildata["name"] = $invoice->customers->name;
            $maildata["title"] = 'Invoice #'.$invoice->ref_no.' | '.$company->name;
            $maildata["view"] = 'mails.invoice';
            $maildata["invoice"] = $invoice;

            (new HelperController)->sendPDFMail($maildata, $pdf, $pdf_name);
        //End
    }
}
