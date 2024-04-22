<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    private function fetchProductsFromCart(Request $request)
    {
        if (!empty($request->session()->get('cart', []))) {
            $cartItems = collect(session('cart', []))->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            $products = DB::table('products')
                ->whereIn('id', $cartItems)
                ->get();
        } else {
            $products = [];
        }
        return $products;
    }

    public function allProductsFromCart(Request $request)
    {
        $products = $this->fetchProductsFromCart($request);

        return view('cart', compact('products'));
    }

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

    public function deleteFromCart(Request $request): RedirectResponse
    {
        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }

        $productId = $request->input('productId');
        $cart = $request->session()->get('cart', []);
        $index = array_search($productId, $cart);

        if ($index !== false) {
            unset($cart[$index]);
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart');

    }

    public function checkOutCart(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'customer_name' => ['required'],
            'customer_contact' => ['required'],
            'customer_comment' => ['required'],
        ]);

       $order = Order::create($validatedData);
        $products = $this->fetchProductsFromCart($request);

        $order->product()->attach($request->session()->get('cart', []));
        $subject = "New Order";
        $to = config('mail.to.address');

        Mail::to($to)->send(new NewOrderMail($subject, $products, $validatedData['customer_name'], $validatedData['customer_contact'], $validatedData['customer_comment']));

        $request->session()->put('cart', []);

        session()->flash('success', 'Your order has been placed');
        return redirect()->route('index');
    }


}
