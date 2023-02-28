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

Auth::routes(['register' => false]);



Route::middleware(['auth'])->group(function () {
    //Home Page
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Admin Access with Inventory Module
    Route::prefix('admin/inventory')->middleware(['is_admin'])->group(function () {
        //Inventory Modules
        Route::get('/', [App\Http\Controllers\Admin\Inventory\IndexController::class, 'index'])->name('admin.inventory.dashboard');
        Route::get('/get_purchase', [App\Http\Controllers\Admin\Inventory\IndexController::class, 'get_purchase'])->name('admin.inventory.dashboard.get_purchase');

        //Category Controller
        Route::get('/categories', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'index'])->name('admin.inventory.category');
        Route::get('/get_categories', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'get_categories'])->name('admin.inventory.get_category');
        Route::get('/categories/create', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'add_new'])->name('admin.inventory.category.create.form');
        Route::post('/categories/create', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'create'])->name('admin.inventory.category.create');
        Route::get('/categories/update/{id}', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'update_form'])->name('admin.inventory.category.update.form');
        Route::post('/categories/update', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'update'])->name('admin.inventory.category.update');
        Route::post('/categories/delete/{id}', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'delete'])->name('admin.inventory.category.delete');
        Route::get('/categories/logs/{id}', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'logs'])->name('admin.inventory.category.logs');
        Route::get('/categories/get_logs/{id}', [App\Http\Controllers\Admin\Inventory\CategoryController::class, 'get_logs'])->name('admin.inventory.category.get_logs');

        //Sub Category Controller
        Route::get('/subcategories', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'index'])->name('admin.inventory.subcategories');
        Route::get('/get_subcategories', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'get_subcategories'])->name('admin.inventory.get_subcategories');
        Route::get('/subcategories/create', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'add_new'])->name('admin.inventory.subcategories.create.form');
        Route::post('/subcategories/create', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'create'])->name('admin.inventory.subcategories.create');
        Route::get('/subcategories/update/{id}', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'update_form'])->name('admin.inventory.subcategories.update.form');
        Route::post('/subcategories/update', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'update'])->name('admin.inventory.subcategories.update');
        Route::post('/subcategories/delete/{id}', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'delete'])->name('admin.inventory.subcategories.delete');
        Route::get('/subcategories/logs/{id}', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'logs'])->name('admin.inventory.subcategories.logs');
        Route::get('/subcategories/get_logs/{id}', [App\Http\Controllers\Admin\Inventory\SubCategoryController::class, 'get_logs'])->name('admin.inventory.subcategories.get_logs');

        //Suppliers Controller
        Route::get('/suppliers', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'index'])->name('admin.inventory.suppliers');
        Route::get('/get_suppliers', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'get_suppliers'])->name('admin.inventory.get_suppliers');
        Route::get('/suppliers/create', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'add_new'])->name('admin.inventory.suppliers.create.form');
        Route::post('/suppliers/create', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'create'])->name('admin.inventory.suppliers.create');
        Route::get('/suppliers/update/{id}', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'update_form'])->name('admin.inventory.suppliers.update.form');
        Route::post('/suppliers/update', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'update'])->name('admin.inventory.suppliers.update');
        Route::post('/suppliers/delete/{id}', [App\Http\Controllers\Admin\Inventory\SupplierController::class, 'delete'])->name('admin.inventory.suppliers.delete');

        //Inventory Controller
        Route::get('/inventories', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'index'])->name('admin.inventory.inventories');
        Route::get('/get_inventories', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'get_inventories'])->name('admin.inventory.get_inventories');
        Route::get('/inventories/create', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'add_new'])->name('admin.inventory.inventories.create.form');
        Route::post('/inventories/create', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'create'])->name('admin.inventory.inventories.create');
        Route::get('/inventories/update/{id}', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'update_form'])->name('admin.inventory.inventories.update.form');
        Route::post('/inventories/update', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'update'])->name('admin.inventory.inventories.update');
        Route::post('/inventories/delete/{id}', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'delete'])->name('admin.inventory.inventories.delete');
        Route::get('/inventories/logs/{id}', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'logs'])->name('admin.inventory.inventories.logs');
        Route::get('/inventories/get_logs/{id}', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'get_logs'])->name('admin.inventory.inventories.get_logs');
        Route::post('/inventories/export', [App\Http\Controllers\Admin\Inventory\InventoryController::class, 'export'])->name('admin.inventory.inventories.export');

        Route::get('/inventories/images/{id}', [App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'index'])->name('admin.inventory.inventories.images');
        Route::get('/inventories/get_images/{id}', [App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'get_images'])->name('admin.inventory.inventories.get_images');
        Route::post('/inventories/images/create', [App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'create'])->name('admin.inventory.inventories.images.create');
        Route::post('/inventories/images/delete/{id}', [App\Http\Controllers\Admin\Inventory\InventoryImageController::class, 'delete'])->name('admin.inventory.inventories.images.delete');

        //Sales Controller
        Route::get('/sales', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'index'])->name('admin.inventory.sales');
        Route::get('/get_sales', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'get_sales'])->name('admin.inventory.get_sales');
        Route::get('/sales/create', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'add_new'])->name('admin.inventory.sales.create.form');
        Route::post('/sales/getprice', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'getprice'])->name('admin.inventory.sales.create.getprice');
        Route::post('/sales/create', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'create'])->name('admin.inventory.sales.create');
        Route::get('/sales/update/{id}', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'update_form'])->name('admin.inventory.sales.update.form');
        Route::post('/sales/update', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'update'])->name('admin.inventory.sales.update');
        Route::post('/sales/delete/{id}', [App\Http\Controllers\Admin\Inventory\SalesController::class, 'delete'])->name('admin.inventory.sales.delete');

        //Sales Controller
        Route::get('/purchases', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'index'])->name('admin.inventory.purchases');
        Route::get('/get_purchases', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'get_purchases'])->name('admin.inventory.get_purchases');
        Route::get('/purchases/create', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'add_new'])->name('admin.inventory.purchases.create.form');
        Route::post('/purchases/product_validation', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'product_validation'])->name('admin.inventory.purchases.product_validation');
        Route::post('/purchases/create', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'create'])->name('admin.inventory.purchases.create');
        Route::get('/purchases/update/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'update_form'])->name('admin.inventory.purchases.update.form');
        Route::post('/purchases/get_items', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'get_items'])->name('admin.inventory.purchases.get.items');
        Route::post('/purchases/delete_items', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'delete_items'])->name('admin.inventory.purchases.delete.items');
        Route::post('/purchases/update', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'update'])->name('admin.inventory.purchases.update');
        Route::post('/purchases/delete/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'delete'])->name('admin.inventory.purchases.delete');
        Route::get('/purchases/logs/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'logs'])->name('admin.inventory.purchases.logs');
        Route::get('/purchases/get_logs/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'get_logs'])->name('admin.inventory.purchases.get_logs');
        Route::get('/purchases/payments/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'payments'])->name('admin.inventory.purchases.payments');
        Route::get('/purchases/get_payments/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'get_payments'])->name('admin.inventory.purchases.get_payments');
        Route::post('/purchases/store_payments', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'store_payments'])->name('admin.inventory.purchases.store_payments');
        Route::post('/purchases/delete_payment', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'delete_payment'])->name('admin.inventory.purchases.delete_payment');
        Route::get('/purchases/download/{id}', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'download'])->name('admin.inventory.purchases.download');
        Route::post('/purchases/export', [App\Http\Controllers\Admin\Inventory\PurchaseController::class, 'export'])->name('admin.inventory.purchases.export');
    });

    //Admin Access with Invoice Module
    Route::prefix('admin/invoices')->middleware(['is_admin'])->group(function () {
        //Invoice Modules Dashboard
        Route::get('/', [App\Http\Controllers\Admin\Invoice\IndexController::class, 'index'])->name('admin.invoice.dashboard');

        //Customer Controller
        Route::get('/customers', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'index'])->name('admin.invoice.customers');
        Route::get('/get_customers', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'get_customers'])->name('admin.invoice.get_customers');
        Route::get('/customers/create', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'add_new'])->name('admin.invoice.customers.create.form');
        Route::post('/customers/create', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'create'])->name('admin.invoice.customers.create');
        Route::get('/customers/update/{id}', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'update_form'])->name('admin.invoice.customers.update.form');
        Route::post('/customers/update', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'update'])->name('admin.invoice.customers.update');
        Route::post('/customers/delete/{id}', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'delete'])->name('admin.invoice.customers.delete');
        Route::get('/customers/logs/{id}', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'logs'])->name('admin.invoice.customers.logs');
        Route::get('/customers/get_logs/{id}', [App\Http\Controllers\Admin\Invoice\CustomerController::class, 'get_logs'])->name('admin.invoice.customers.get_logs');

        //Invoice Controller
        Route::get('/invoices', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'index'])->name('admin.invoice.invoices');
        Route::get('/get_invoices', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'get_invoices'])->name('admin.invoice.get_invoices');
        Route::get('/invoices/create', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'add_new'])->name('admin.invoice.invoices.create.form');
        Route::post('/invoices/get_product_info', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'get_product_info'])->name('admin.invoice.invoices.get_product_info');
        Route::post('/invoices/product_validation', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'product_validation'])->name('admin.invoice.invoices.product_validation');
        Route::post('/invoices/create', [App\Http\Controllers\Admin\Invoice\InvoiceController::class, 'create'])->name('admin.invoice.invoices.create');
    });

    //Admin Access with Invoice Module
    Route::prefix('admin/staffs')->middleware(['is_admin'])->group(function () {
        //Staff Modules Dashboard
        Route::get('/', [App\Http\Controllers\Admin\Staff\IndexController::class, 'index'])->name('admin.staffs.dashboard');
        Route::get('/get_monthly_salary', [App\Http\Controllers\Admin\Staff\IndexController::class, 'get_monthly_salary'])->name('admin.staffs.dashboard.get_monthly_salary');

        //Staff Controller
        Route::get('/staffs', [App\Http\Controllers\Admin\Staff\StaffController::class, 'index'])->name('admin.staffs.staffs');
        Route::get('/get_staffs', [App\Http\Controllers\Admin\Staff\StaffController::class, 'get_staffs'])->name('admin.staffs.get_staffs');
        Route::get('/staffs/create', [App\Http\Controllers\Admin\Staff\StaffController::class, 'add_new'])->name('admin.staffs.staffs.create.form');
        Route::post('/staffs/create', [App\Http\Controllers\Admin\Staff\StaffController::class, 'create'])->name('admin.staffs.staffs.create');
        Route::get('/staffs/update/{id}', [App\Http\Controllers\Admin\Staff\StaffController::class, 'update_form'])->name('admin.staffs.staffs.update.form');
        Route::post('/staffs/update', [App\Http\Controllers\Admin\Staff\StaffController::class, 'update'])->name('admin.staffs.staffs.update');
        Route::post('/staffs/delete/{id}', [App\Http\Controllers\Admin\Staff\StaffController::class, 'delete'])->name('admin.staffs.staffs.delete');

        //Staff Salary Controller
        Route::get('/salary', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'index'])->name('admin.staffs.salary');
        Route::get('/get_salary', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'get_salary'])->name('admin.staffs.get_salary');
        Route::get('/salary/create', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'add_new'])->name('admin.staffs.salary.create.form');
        Route::post('/salary/validation', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'validation'])->name('admin.staffs.salary.validation');
        Route::post('/salary/create', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'create'])->name('admin.staffs.salary.create');
        Route::get('/salary/update/{id}', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'update_form'])->name('admin.staffs.salary.update.form');
        Route::post('/salary/update', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'update'])->name('admin.staffs.salary.update');
        Route::post('/salary/delete/{id}', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'delete'])->name('admin.staffs.salary.delete');
        Route::post('/salary/export', [App\Http\Controllers\Admin\Staff\StaffSalaryController::class, 'export'])->name('admin.staffs.salary.export');
    });
});
