<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Exports\InvoiceExport;
use PDF;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\InvoiceLog;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\InvoicePayment;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\Invoice\InvoiceController as InvoiceInvoiceController;

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
        $product = Inventory::where('status',1)->get();
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

    public function payments_form($id)
    {
        $id = Crypt::decrypt($id);
        $invoices = Invoice::find($id);
        $pay_type = PaymentMethod::all();

        return view('admin.invoice.invoice.payments',[
            'pay_type' => $pay_type,
            'invoices' => $invoices
        ]);
    }

    public function get_payments($id)
    {
        $data = (new InvoiceInvoiceController)->get_payments($id);

        return $data;
    }

    public function store_payments(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pay_method' => 'required',
                'paid_date' => 'required',
                'paid_amount' => 'required|numeric|between:1,9999999999.99',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InvoiceInvoiceController)->store_payments($request);

        return response()->json(['status' => true,  'message' => 'New Payment added successfully']);
    }

    public function delete_payments(Request $request)
    {
        $payment = InvoicePayment::find($request->id);
        $invoice = Invoice::find($payment->invoice_id);
        $invoice->status = $invoice->status == 1 ? 0 : 0;
        $invoice->update();

        InvoicePayment::destroy($request->id);

        //Store the Invoice Log
        $logs = new InvoiceLog();
        $logs->inv_id = $invoice->id;
        $logs->user_id = Auth::user()->id;
        $logs->work = 'Delete payment';
        $logs->save();

        return response()->json(['status' => true,  'message' => 'Selected Payment deleted successfully']);
    }

    public function delete(Request $request)
    {
        $invoice = Invoice::find($request->id);

        //Delete the Payments
        $invoice->invoicePayment()->delete();

        //Increase the Invetory
        foreach ($invoice->invoiceItems as $item) {
            $inventory = Inventory::find($item->product_id);

            if ($inventory) {

                $inventory->qty = $inventory->qty + $item->qty;
                $inventory->update();
            }
        }

        //Delete Invoice Items
        $invoice->invoiceItems()->delete();

        //Delete Invoice
        Invoice::destroy($request->id);

        return response()->json(['status' => true,  'message' => 'Selected Invoice deleted successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);

        $invoice = Invoice::find($id);

        return view('admin.invoice.invoice.logs',[
            'invoice' => $invoice
        ]);
    }

    public function get_logs($id)
    {
        $category = InvoiceLog::with(['getCreator'])->where('inv_id',$id)->orderBy('id','DESC');

        $data =  Datatables::of($category)
            ->addIndexColumn()

            ->addColumn('created', function ($item) {
                return ucwords($item->getCreator->name);
            })
            ->addColumn('acc_date', function ($item) {
                return date('Y-m-d h:i:s A', strtotime($item->created_at));
            })
            ->rawColumns(['created','acc_date'])
            ->make(true);

        return $data;
    }

    public function download($id)
    {
        $id = Crypt::decrypt($id);

        $invoice = Invoice::find($id);
        $company = Company::find(1);

        $data = [
            'invoice' => $invoice,
            'company' =>$company,
            'url' => url($company->image)
        ];

        $pdf = PDF::loadView('download.invoice', $data);
        return $pdf->download('invoice' . date('Ymdhis') . '.pdf');
    }

    public function export(Request $request)
    {
        $data = (new InvoiceInvoiceController)->invoiceExport($request);

        $customer_name = '';
        if (isset($request->customer) && !empty($request->customer))
        {
            $customer = Customer::find($request->customer);
            $customer_name = $customer->name;
        }

        $file_name = 'invoice' . date('_YmdHis') . '.xlsx';
        return Excel::download(new InvoiceExport($data, count($data),$request,$customer_name), $file_name);
    }

    public function send_mail($id)
    {
        (new InvoiceInvoiceController)->send_mail($id);

        return redirect()->back()->with('mail_success','Selected Invoice Details Sent to the Custmer mail Successfully');
    }
}
