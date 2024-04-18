<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request): RedirectResponse
    {
        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }

        $productId = $request->input('productId');
        $cart = $request->session()->get('cart', []);

        if (!in_array($productId, $cart)) {
            $cart[] = $productId;
            $request->session()->put('cart', $cart);
        }

        return redirect()->route('index');

    }
}
