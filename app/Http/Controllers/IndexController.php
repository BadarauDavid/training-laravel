<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        $productsQuery = Product::query();
        if (!empty($cartItems)) {
            $cartItems = collect($cartItems)->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            $productsQuery->whereNotIn('id', $cartItems)->get();
        }

        $products = $productsQuery->get();
        $data = compact('products');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('index', $data);

    }
}
