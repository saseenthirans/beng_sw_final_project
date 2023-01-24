<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Auth::routes(['register'=>false]);



Route::middleware(['auth'])->group(function () {
    //Home Page
    Route::get('home',[App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Admin Access with Inventory Module
    Route::prefix('admin/inventory')->middleware(['is_admin'])->group(function () {
        //Inventory Modules
        Route::get('/',[App\Http\Controllers\Admin\Inventory\IndexController::class, 'index'])->name('admin.inventory.dashboard');

        //Category Controller
        Route::get('/categories',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'index'])->name('admin.inventory.category');
        Route::get('/get_categories',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'get_categories'])->name('admin.inventory.get_category');
        Route::get('/categories/create',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'add_new'])->name('admin.inventory.category.create.form');
        Route::post('/categories/create',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'create'])->name('admin.inventory.category.create');
        Route::get('/categories/update/{id}',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'update_form'])->name('admin.inventory.category.update.form');
        Route::post('/categories/update',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'update'])->name('admin.inventory.category.update');
        Route::post('/categories/delete/{id}',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'delete'])->name('admin.inventory.category.delete');
        Route::get('/categories/logs/{id}',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'logs'])->name('admin.inventory.category.logs');
        Route::get('/categories/get_logs/{id}',[App\Http\Controllers\Admin\Inventory\CategoryController::class, 'get_logs'])->name('admin.inventory.category.get_logs');

        //Sub Category Controller
        Route::get('/subcategories',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'index'])->name('admin.inventory.subcategories');
        Route::get('/get_subcategories',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'get_subcategories'])->name('admin.inventory.get_subcategories');
        Route::get('/subcategories/create',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'add_new'])->name('admin.inventory.subcategories.create.form');
        Route::post('/subcategories/create',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'create'])->name('admin.inventory.subcategories.create');
        Route::get('/subcategories/update/{id}',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'update_form'])->name('admin.inventory.subcategories.update.form');
        Route::post('/subcategories/update',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'update'])->name('admin.inventory.subcategories.update');
        Route::post('/subcategories/delete/{id}',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'delete'])->name('admin.inventory.subcategories.delete');
        Route::get('/subcategories/logs/{id}',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'logs'])->name('admin.inventory.subcategories.logs');
        Route::get('/subcategories/get_logs/{id}',[App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'get_logs'])->name('admin.inventory.subcategories.get_logs');

        //Suppliers Controller
        Route::get('/suppliers',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'index'])->name('admin.inventory.suppliers');
        Route::get('/get_suppliers',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'get_suppliers'])->name('admin.inventory.get_suppliers');
        Route::get('/suppliers/create',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'add_new'])->name('admin.inventory.suppliers.create.form');
        Route::post('/suppliers/create',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'create'])->name('admin.inventory.suppliers.create');
        Route::get('/suppliers/update/{id}',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'update_form'])->name('admin.inventory.suppliers.update.form');
        Route::post('/suppliers/update',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'update'])->name('admin.inventory.suppliers.update');
        Route::post('/suppliers/delete/{id}',[App\Http\Controllers\Admin\Inventory\SupplierController::class, 'delete'])->name('admin.inventory.suppliers.delete');

        //Inventory Controller
        Route::get('/inventories',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'index'])->name('admin.inventory.inventories');
        Route::get('/get_inventories',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'get_inventories'])->name('admin.inventory.get_inventories');
        Route::get('/inventories/create',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'add_new'])->name('admin.inventory.inventories.create.form');
        Route::post('/inventories/create',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'create'])->name('admin.inventory.inventories.create');
        Route::get('/inventories/update/{id}',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'update_form'])->name('admin.inventory.inventories.update.form');
        Route::post('/inventories/update',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'update'])->name('admin.inventory.inventories.update');
        Route::post('/inventories/delete/{id}',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'delete'])->name('admin.inventory.inventories.delete');
        Route::get('/inventories/logs/{id}',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'logs'])->name('admin.inventory.inventories.logs');
        Route::get('/inventories/get_logs/{id}',[App\Http\Controllers\Admin\Inventory\InventoryController::class, 'get_logs'])->name('admin.inventory.inventories.get_logs');

        Route::get('/inventories/images/{id}',[App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'index'])->name('admin.inventory.inventories.images');
        Route::get('/inventories/get_images/{id}',[App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'get_images'])->name('admin.inventory.inventories.get_images');
        Route::post('/inventories/images/create',[App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'create'])->name('admin.inventory.inventories.images.create');
        Route::post('/inventories/images/delete/{id}',[App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'delete'])->name('admin.inventory.inventories.images.delete');

        //Sales Controller
        Route::get('/sales',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'index'])->name('admin.inventory.sales');
        Route::get('/get_sales',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'get_sales'])->name('admin.inventory.get_sales');
        Route::get('/sales/create',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'add_new'])->name('admin.inventory.sales.create.form');
        Route::post('/sales/getprice',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'getprice'])->name('admin.inventory.sales.create.getprice');
        Route::post('/sales/create',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'create'])->name('admin.inventory.sales.create');
        Route::get('/sales/update/{id}',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'update_form'])->name('admin.inventory.sales.update.form');
        Route::post('/sales/update',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'update'])->name('admin.inventory.sales.update');
        Route::post('/sales/delete/{id}',[App\Http\Controllers\Admin\Inventory\SalesController::class, 'delete'])->name('admin.inventory.sales.delete');

         //Sales Controller
         Route::get('/purchases',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'index'])->name('admin.inventory.purchases');
         Route::get('/get_purchases',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'get_purchases'])->name('admin.inventory.get_purchases');
         Route::get('/purchases/create',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'add_new'])->name('admin.inventory.purchases.create.form');
         Route::post('/purchases/create',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'create'])->name('admin.inventory.purchases.create');
         Route::get('/purchases/update/{id}',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'update_form'])->name('admin.inventory.purchases.update.form');
         Route::post('/purchases/update',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'update'])->name('admin.inventory.purchases.update');
         Route::post('/purchases/delete/{id}',[App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'delete'])->name('admin.inventory.purchases.delete');
    });

});
