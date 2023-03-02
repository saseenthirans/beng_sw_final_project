<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Base\Invoice\DashboardController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $data = (new DashboardController)->countAmount();

        return view('admin.invoice.index',[
            'data' => $data
        ]);
    }

    public function get_invoice_count()
    {
        $data = (new DashboardController)->invoiceChart();

        return response()->json(['data' =>$data]);
    }
}
