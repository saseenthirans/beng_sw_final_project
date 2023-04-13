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
    return view('auth.login');
});

// Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home.index');
Route::get('/categories/{id}', [App\Http\Controllers\HomeController::class, 'categories'])->name('home.categories');
Route::get('/sub_categories/{id}', [App\Http\Controllers\HomeController::class, 'sub_categories'])->name('home.sub_categories');
Route::get('/products/{id}', [App\Http\Controllers\HomeController::class, 'products'])->name('home.products');
Route::post('/add_to_cart', [App\Http\Controllers\Cart\CartController::class, 'add_to_cart'])->name('home.cart.add_to_cart');

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    //Home Page
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
