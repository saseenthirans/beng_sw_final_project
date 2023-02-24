<?php

namespace App\Http\Controllers\Base;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
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
}
