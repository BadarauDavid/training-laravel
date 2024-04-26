<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->session()->get('cart', []))) {
            $cartItems = collect(session('cart', []))->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            $products = Product::whereNotIn('id', $cartItems)->get();

        } else {
            $products = Product::all();
        }

        $data = compact('products');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('index', $data);
    }
}
