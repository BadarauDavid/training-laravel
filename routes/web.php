<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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

Route::get('/index', [ProductController::class,'index'])->name('index');
Route::get('/cart', [CartController::class,'allProductsFromCart'])->name('cart');
Route::get('/addToCart', [CartController::class,'addToCart'])->name('addToCart');
Route::get('/deleteFromCart', [CartController::class,'deleteFromCart'])->name('deleteFromCart');
Route::post('/checkOutCart', [CartController::class,'checkOutCart'])->name('checkOutCart');

Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/handleLogin', [LoginController::class,'login'])->name('handleLogin');
Route::post('/logout', [LogoutController::class,'logout'])->name('logout')->middleware('auth');

