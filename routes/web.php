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
    });

});
