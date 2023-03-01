<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Exports\PurchaseExport;
use App\Http\Controllers\Base\ExportController;
use PDF;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\PurchaseLog;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PurchasePayment;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\InventoryPurchaseController;

class PurchaseController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where('status', 1)->get();

        return view('admin.inventory.purchase.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function get_purchases(Request $request)
    {
        $data = (new InventoryPurchaseController)->index($request);

        return $data;
    }

    public function add_new()
    {
        $suppliers = Supplier::where('status', 1)->get();
        $inventory = Inventory::all();
        $paymethod = PaymentMethod::all();

        return view('admin.inventory.purchase.create', [
            'suppliers' => $suppliers,
            'inventory' => $inventory,
            'paymethod' => $paymethod
        ]);
    }

    public function product_validation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product' => 'required',
                'qty' => 'required|numeric|min:1',
                'price' => 'required|numeric|between:0,9999999999.99'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false,  'errors' => $validator->errors()]);
        }

        $product = Inventory::find($request->product);

        if ($request->id) {

            (new InventoryPurchaseController)->add_items($request, $product);

        }

        return response()->json(['status' => true, 'data' => [
            'product_id' => $product->id,
            'product_name' => $product->code . ' - ' . $product->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'price_' => number_format($request->price, 2),
            'total' => $request->qty * $request->price,
            'total_' => number_format(($request->qty * $request->price), 2)
        ]]);
    }

    public function create(Request $request)
    {
        if ($request->is_paid == true) {
            $validator = Validator::make(
                $request->all(),
                [
                    'invoice_number' => 'required|unique:purchases,invoice,NULL,id,deleted_at,NULL',
                    'supplier' => 'required',
                    'purchased_date' => 'required',
                    'pay_method' => 'required',
                    'paid_date' => 'required',
                    'paid_amount' => 'required|numeric|between:0,9999999999.99',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'invoice_number' => 'required|unique:purchases,invoice,NULL,id,deleted_at,NULL',
                    'supplier' => 'required',
                    'purchased_date' => 'required',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InventoryPurchaseController)->create($request);

        return response()->json(['status' => true,  'message' => 'New Purchases Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $purchase = Purchase::find($id);

        $suppliers = Supplier::where('status', 1)->get();
        $inventory = Inventory::all();
        $paymethod = PaymentMethod::all();

        return view('admin.inventory.purchase.update', [
            'suppliers' => $suppliers,
            'inventory' => $inventory,
            'paymethod' => $paymethod,
            'purchase' => $purchase
        ]);
    }

    public function get_items(Request $request)
    {
        $id = $request->id;
        $purchaseItem = PurchaseItem::with('product')->where('pur_id', $id)->get();

        $data = [];

        foreach ($purchaseItem as $item) {
            $data[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->code . ' - ' . $item->product->name,
                'qty' => $item->qty,
                'price' => $item->unit_price,
                'price_' => number_format($item->unit_price, 2),
                'total' => $item->qty * $item->unit_price,
                'total_' => number_format(($item->qty * $item->unit_price), 2)
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function delete_items(Request $request)
    {
        (new InventoryPurchaseController)->delete_items($request);

        return response()->json(['delted']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'invoice_number' => 'required|unique:purchases,invoice,'.$request->id.',id,deleted_at,NULL',
                'supplier' => 'required',
                'purchased_date' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InventoryPurchaseController)->update($request);

        return response()->json(['status' => true,  'message' => 'Selected Purchases Updated Successfully']);
    }

    public function delete($id)
    {
        (new InventoryPurchaseController)->delete($id);

        return response()->json(['status' => true,  'message' => 'Selected Purchases Deleted Successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);
        $purchase = Purchase::find($id);

        return view('admin.inventory.purchase.logs',[
            'purchase' => $purchase
        ]);
    }

    public function get_logs($id)
    {
        $category = PurchaseLog::with(['getCreator'])->where('pur_id',$id)->orderBy('id','DESC');

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

    public function payments($id)
    {
        $id = Crypt::decrypt($id);
        $purchase = Purchase::find($id);
        $paymethod = PaymentMethod::all();

        return view('admin.inventory.purchase.payments',[
            'purchase' => $purchase,
            'paymethod' => $paymethod
        ]);
    }

    public function get_payments($id)
    {
        $data = (new InventoryPurchaseController)->get_payments($id);

        return $data;
    }

    public function store_payments(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pay_method' => 'required',
                'paid_date' => 'required',
                'paid_amount' => 'required|numeric|between:0,9999999999.99',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        (new InventoryPurchaseController)->store_payments($request);

        return response()->json(['status' => true,  'message' => 'New Payment added successfully']);
    }

    public function delete_payment(Request $request)
    {
        PurchasePayment::destroy($request->id);

        $pur_log = new PurchaseLog();
        $pur_log->pur_id = $request->pur_id;
        $pur_log->user_id = Auth::user()->id;
        $pur_log->work = "Delete Payment";
        $pur_log->save();

        return response()->json(['status' => true,  'message' => 'Selected Payment deleted successfully']);
    }

    public function download($id)
    {
        $id = Crypt::decrypt($id);

        $purchase = Purchase::find($id);

        $data = [
            'purchase' => $purchase
        ];

        $pdf = PDF::loadView('admin.inventory.purchase.download', $data);
        return $pdf->download('purchase' . date('Ymdhis') . '.pdf');
    }

    public function export(Request $request)
    {
        $data = (new ExportController)->purchaseExport($request);

        $supplier_name = '';
        if (isset($request->supplier) && !empty($request->supplier))
        {
            $supplier = Supplier::find($request->supplier);
            $supplier_name = $supplier->name;
        }

        $file_name = 'purchased' . date('_YmdHis') . '.xlsx';
        return Excel::download(new PurchaseExport($data, count($data),$request,$supplier_name), $file_name);
    }
}
