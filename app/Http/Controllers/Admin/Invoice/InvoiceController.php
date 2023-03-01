<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Base\Invoice\InvoiceController as InvoiceInvoiceController;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $customers = Customer::where('status',1)->get();

        return view('admin.invoice.invoice.index',[
            'invoices' => $invoices,
            'customers' => $customers
        ]);
    }

    public function get_invoices(Request $request)
    {
        $data = (new InvoiceInvoiceController)->index($request);

        return $data;
    }

    public function add_new()
    {
        $customers = Customer::where('status',1)->get();
        $product = Inventory::where('status',1)->get();
        $pay_type = PaymentMethod::all();

        return view('admin.invoice.invoice.create',[
            'customers' => $customers,
            'product' => $product,
            'pay_type' => $pay_type
        ]);
    }

    public function get_product_info(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $product = Inventory::find($request->id);

            return response()->json(['product'=>$product]);
        }

    }

    public function product_validation(Request $request)
    {
        $product = Inventory::find($request->product);

        $validator = Validator::make(
            $request->all(),
            [
                'product' => 'required',
                'qty' => 'required|numeric|min:1|max:'.$product->qty,
                'price' => 'required|numeric|between:1,9999999999.99',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        if (isset($request->prduct_arry) && !empty($request->prduct_arry)) {
            if (in_array($request->product, $request->prduct_arry)) {
                return response()->json(['status' => false, 'message' => 'Product Already Exists']);
            }
        }

        if(isset($request->invoice_id) && !empty($request->invoice_id))
        {
            $invoices = Invoice::find($request->invoice_id);

            //Store Invoice Item
            (new InvoiceInvoiceController)->addInvoiceItem($request, $invoices);
        }

        return response()->json(['status' => true,
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->code . ' - ' . $product->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'priceval' => number_format($request->price,2),
                'total' => number_format(($request->qty * $request->price),2),
                'amount' => $request->qty * $request->price
            ]
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer' => 'required',
                'date' => 'required',
                'discount' => 'required|numeric|max:100|min:0',
                'tax_amount' => 'required|numeric|between:0,9999999999.99|min:0',
                'paid_amount' => 'required|numeric|between:0,9999999999.99|min:0|max:'.$request->total_amount,
                'pay_type' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        if (!isset($request->product_id) && empty($request->product_id)) {
            return response()->json(['status' => false,  'message' => 'Please add atleast one Product']);
        }

        //Store Invoice Data
        (new InvoiceInvoiceController)->create($request);

        return response()->json(['status' => true,  'message' => 'New Invoice Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $invoices = Invoice::find($id);

        $customers = Customer::withTrashed()->get();
        $product = Inventory::withTrashed()->get();
        $pay_type = PaymentMethod::all();

        return view('admin.invoice.invoice.update',[
            'customers' => $customers,
            'product' => $product,
            'pay_type' => $pay_type,
            'invoices' => $invoices
        ]);
    }

    public function get_invoice_items(Request $request)
    {
        $id = $request->id;
        $invoices = Invoice::find($id);

        $data = [];

        foreach($invoices->invoiceItems as $item)
        {
            $data[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->code.' - '. $item->product->name,
                'qty' => $item->qty,
                'price' => $item->amount,
                'total' => $item->total
            ];
        }

        return response()->json(['data'=>$data]);
    }

    public function delete_invoice_items(Request $request)
    {
        (new InvoiceInvoiceController)->deleteInvoiceItem($request);
        return response()->json(['message'=>'deleted']);
    }

    public function update(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $validator = Validator::make(
            $request->all(),
            [
                'customer' => 'required',
                'date' => 'required',
                'discount' => 'required|numeric|max:100|min:0',
                'tax_amount' => 'required|numeric|between:0,9999999999.99|min:0',
                'paid_amount' => 'required|numeric|between:0,9999999999.99|min:0|max:'.$request->total_amount,
                'pay_type' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        if (count($invoice->invoiceItems) == 0) {
            return response()->json(['status' => false,  'message' => 'Please add atleast one Product']);
        }

        //Store Invoice Data
        (new InvoiceInvoiceController)->update($request);

        return response()->json(['status' => true,  'message' => 'Selected Invoice Updated Successfully']);
    }
}
