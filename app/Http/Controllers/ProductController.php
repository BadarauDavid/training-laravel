<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->session()->get('cart', []))) {
            $cartItems = collect(session('cart', []))->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            $products = DB::table('products')
                ->whereNotIn('id', $cartItems)
                ->get();
        } else {
            $products = Product::all();
        }

        return view('index', compact('products'));
    }
}
