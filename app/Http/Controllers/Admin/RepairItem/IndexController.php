<?php

namespace App\Http\Controllers\Admin\RepairItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.repair_item.index');
    }
}
