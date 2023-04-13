<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Inventory;
use App\Models\Sales;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{

    public function index()
    {
        $company = Company::find(1);
        return view('home', ['company'=>$company]);
    }

    public function home()
    {
        $categories = Category::where('status',1)->orderBy('name')->get();
        $home_categories = Category::where(['status'=>1,'is_home'=>1])->orderBy('name')->get();
        $deals = Sales::where('status',1)->get();

        return view('home.index',[
            'categories' => $categories,
            'deals' => $deals,
            'home_categories' => $home_categories
        ]);
    }

    public function categories($id)
    {
        $id = Crypt::decrypt($id);
        $category = Category::find($id);
        $sub_category = SubCategory::where('category_id',$id)->orderBy('name','ASC')->get();

        return view('home.category',[
            'category' => $category,
            'sub_category' => $sub_category
        ]);
    }

    public function sub_categories($id)
    {
        $id = Crypt::decrypt($id);
        $subcategory = SubCategory::find($id);

        return view('home.subcategory',[
            'subcategory' => $subcategory
        ]);
    }

    public function products($id)
    {
        $id = Crypt::decrypt($id);
        $inventory = Inventory::find($id);

        return view('home.products',[
            'inventory' => $inventory
        ]);
    }
}
