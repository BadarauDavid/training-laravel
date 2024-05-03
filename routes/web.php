<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::get('/index', [IndexController::class, 'index'])->name('index');

Route::get('/cart', [CartController::class, 'allProducts'])->name('cart');
Route::get('/addToCart', [CartController::class, 'add'])->name('addToCart');
Route::get('/deleteFromCart', [CartController::class, 'delete'])->name('deleteFromCart');
Route::post('/checkOutCart', [CartController::class, 'checkOut'])->name('checkOutCart');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/handleLogin', [LoginController::class, 'login'])->name('handleLogin')->middleware('guest');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/products', [ProductController::class, 'all'])->name('products')->middleware('auth');
Route::get('/addProduct', [ProductController::class, 'add'])->name('addProduct')->middleware('auth');
Route::get('/product', [ProductController::class, 'edit'])->name('product')->middleware('auth');
Route::post('/deleteProduct', [ProductController::class, 'delete'])->name('deleteProduct')->middleware('auth');
Route::post('/handleProduct', [ProductController::class, 'handle'])->name('handleProduct')->middleware('auth');

Route::get('/order', [OrderController::class, 'showOne'])->name('order')->middleware('auth');
Route::get('/orders', [OrderController::class, 'all'])->name('orders')->middleware('auth');

Route::get('/spa', function () {
    return view('spa');
});
