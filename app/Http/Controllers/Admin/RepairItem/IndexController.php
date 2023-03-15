<?php

namespace App\Http\Controllers\Admin\RepairItem;

use App\Http\Controllers\Base\RepairItem\DasshboardController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $dashboard;

    public function __construct()
    {
        $this->dashboard = new DasshboardController();
    }

    public function index()
    {
        $count = $this->dashboard->countsMonth();
        $amount = $this->dashboard->amountMonth();

        return view('admin.repair_item.index',[
            'count' => $count,
            'amount' => $amount
        ]);
    }

    public function get_monthly_income()
    {
        $data = $this->dashboard->repairingChart();

       return response()->json(['data'=>$data]);
    }
}
