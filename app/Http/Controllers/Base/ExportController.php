<?php

namespace App\Http\Controllers\Base;

use App\Models\Purchase;
use App\Models\Inventory;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function inventoryExport($request)
    {
        $query = Inventory::with(['category']);
        if(isset($request->category) && !empty($request->category))
            $query = $query->where('category_id', $request->category);

        if(isset($request->qty) && !empty($request->qty))
            $query = $query->where('qty', '<=' ,$request->qty);

        $inventory = $query->orderBy('id','DESC')->get();

        return $inventory;
    }

    public function purchaseExport($request)
    {
        $query = Purchase::with(['supplier','purPayments']);

        if (isset($request->supplier) && !empty($request->supplier))
            $query = $query->where('supplier_id', $request->supplier);

        if (isset($request->status) && !empty($request->status))
            $query = $query->where('status', $request->status);

        if (isset($request->start_date) && !empty($request->start_date))
            $query = $query->whereDate('pur_date','>=', $request->start_date);

        if (isset($request->end_date) && !empty($request->end_date))
            $query = $query->whereDate('pur_date','<=', $request->end_date);

        $purchases = $query->orderBy('id', 'DESC')->get();

        return $purchases;
    }

    public function staffSalaryExport($request)
    {
        $query = StaffSalary::with('staff');
            if (isset($request->staff) && !empty($request->staff))
                $query = $query->where('user_id',$request->staff);

            if (isset($request->start_date) && !empty($request->start_date))
                $query = $query->whereDate('updated_at','>=', $request->start_date);

            if (isset($request->end_date) && !empty($request->end_date))
                $query = $query->whereDate('updated_at','<=', $request->end_date);

        $salary = $query->orderBy('id','DESC')->get();

        return $salary;
    }
}
