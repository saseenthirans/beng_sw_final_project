<?php

namespace App\Http\Controllers\Admin\RepairItem;

use App\Exports\RepairingExport;
use PDF;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Repairing;
use App\Models\RepairingLog;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\RepairCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\RepairItem\RepairingController as RepairItemRepairingController;

class RepairingController extends Controller
{
    private $baseRepair;

    public function __construct()
    {
        $this->baseRepair = new RepairItemRepairingController();
    }

    public function index()
    {
        $repairing = Repairing::all();
        $category = RepairCategory::all();

        return view('admin.repair_item.repairing.index',[
            'repairing'=>$repairing,
            'category' => $category
        ]);
    }

    public function get_repairing(Request $request)
    {
        $data = $this->baseRepair->index($request);

        return $data;
    }

    public function add_new()
    {
        $customers = Customer::where('status',1)->get();
        $product = Inventory::where('status',1)->get();
        $pay_type = PaymentMethod::all();
        $category = RepairCategory::where('status',1)->get();

        return view('admin.repair_item.repairing.create',[
            'customers' => $customers,
            'product' => $product,
            'pay_type' => $pay_type,
            'category' => $category
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

        if(isset($request->repair_id) && !empty($request->repair_id))
        {
            $repairing = Repairing::find($request->repair_id);

            //Store Invoice Item
            $this->baseRepair->addRepairItem($request, $repairing);
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
                'title' => 'required',
                'date' => 'required',
                'customer' => 'required',
                'category' => 'required',
                'service_charge' => 'required|numeric|between:0,9999999999.99|min:0',
                'paid_amount' => 'required|numeric|between:0,9999999999.99|min:0|max:'.$request->sub_total
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $this->baseRepair->create($request);

        return response()->json(['status' => true,  'message' => 'New Repairing Details Created Successfully']);
    }

    public function update_form($id)
    {
        $id = Crypt::decrypt($id);
        $repairing = Repairing::find($id);

        $customers = Customer::where('status',1)->get();
        $product = Inventory::where('status',1)->get();
        $pay_type = PaymentMethod::all();
        $category = RepairCategory::where('status',1)->get();

        return view('admin.repair_item.repairing.update',[
            'customers' => $customers,
            'product' => $product,
            'pay_type' => $pay_type,
            'category' => $category,
            'repairing' => $repairing
        ]);
    }

    public function get_repairing_items(Request $request)
    {
        $id = $request->id;
        $invoices = Repairing::find($id);

        $data = [];

        if (count($invoices->repairItems)) {
            foreach($invoices->repairItems as $item)
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
        }

        return response()->json(['data'=>$data]);
    }

    public function delete_repairing_items(Request $request)
    {
        $this->baseRepair->deleteItems($request);
        return response()->json(['message'=>'deleted']);
    }

    public function update(Request $request)
    {
        if ($request->status == 2) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'date' => 'required',
                    'customer' => 'required',
                    'category' => 'required',
                    'service_charge' => 'required|numeric|between:0,9999999999.99|min:0',
                    'paid_amount' => 'required|numeric|between:0,9999999999.99|min:0|max:'.$request->sub_total,
                    'collect_before' => 'required'
                ]
            );
        }
        else if ($request->status == 3) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'date' => 'required',
                    'customer' => 'required',
                    'category' => 'required',
                    'service_charge' => 'required|numeric|between:0,9999999999.99|min:0',
                    'paid_amount' => 'required|numeric|between:0,9999999999.99|min:'.$request->sub_total.'|'.'max:'.$request->sub_total
                ]
            );
        }
        else {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'date' => 'required',
                    'customer' => 'required',
                    'category' => 'required',
                    'service_charge' => 'required|numeric|between:0,9999999999.99|min:0',
                    'paid_amount' => 'required|numeric|between:0,9999999999.99|min:0|max:'.$request->sub_total
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['status' => false, 'statuscode' => 400, 'errors' => $validator->errors()]);
        }

        $this->baseRepair->update($request);

        return response()->json(['status' => true,  'message' => 'Selected Repairing Details Updated Successfully']);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $repairing =Repairing::find($id);

        if ($repairing->status != 3) {
            //Increase the Invetory
            foreach ($repairing->repairItems as $item) {
                $inventory = Inventory::find($item->product_id);

                if ($inventory) {

                    $inventory->qty = $inventory->qty + $item->qty;
                    $inventory->update();
                }
            }

            //Delete Invoice Items
            $repairing->repairItems()->delete();
        }

        //Delete Invoice
        Repairing::destroy($request->id);

        return response()->json(['status' => true,  'message' => 'Selected Repairing deleted successfully']);
    }

    public function logs($id)
    {
        $id = Crypt::decrypt($id);
        $repairing = Repairing::find($id);

        return view('admin.repair_item.repairing.logs',['repairing'=>$repairing]);
    }

    public function get_logs($id)
    {
        $category = RepairingLog::with(['getCreator'])->where('repairing_id',$id)->orderBy('id','DESC');

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

        $repairing = Repairing::find($id);
        $company = Company::find(1);

        $data = [
            'repairing' => $repairing,
            'company' =>$company,
            'url' => url($company->image)
        ];

        $pdf = PDF::loadView('download.repairing', $data);
        return $pdf->download('repairing' . date('Ymdhis') . '.pdf');
    }

    public function export(Request $request)
    {
        $data = $this->baseRepair->repairingExport($request);

        $category_name = '';
        if (isset($request->category) && !empty($request->category))
        {
            $category = RepairCategory::find($request->category);
            $category_name = $category->category;
        }

        $file_name = 'repairing' . date('_YmdHis') . '.xlsx';
        return Excel::download(new RepairingExport($data, count($data),$request,$category_name), $file_name);
    }
}
