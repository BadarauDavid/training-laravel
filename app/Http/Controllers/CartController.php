<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    private function fetchProductsFromCart(Request $request)
    {
        if (!empty($request->session()->get('cart', []))) {
            $cartItems = collect(session('cart', []))->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            $products = Product::whereIn('id', $cartItems)->get();
        } else {
            $products = [];
        }
        return $products;
    }

    public function allProductsFromCart(Request $request)
    {
        $products = $this->fetchProductsFromCart($request);

        $data = compact('products');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('cart', $data);
    }

    public function addToCart(Request $request)
    {

        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }

        $productId = $request->input('productId');
        $cart = $request->session()->get('cart', []);


        if (!in_array($productId, $cart)) {
            $cart[] = $productId;
            $request->session()->put('cart', $cart);
            $message = 'Product add successfully';
        } else {
            $message = 'Product already added to cart';
        }

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }

    public function deleteFromCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $productId = $request->input('productId');


        if (!is_numeric($productId) || !in_array($productId, $cart)) {
            return $request->isXmlHttpRequest() ?
                response()->json(['error' => 'Invalid product or product not found in cart']) :
                redirect()->route('cart')->with('error', 'Invalid product or product not found in cart');
        }


        foreach ($cart as $key => $value) {
            if ($value == $productId) {
                unset($cart[$key]);
                break;
            }
        }

        $request->session()->put('cart', $cart);

        return $request->isXmlHttpRequest() ?
            response()->json(['success' => 'Product removed from cart successfully']) :
            redirect()->route('cart')->with('success', 'Product removed from cart successfully');
    }

    public function checkOutCart(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => ['required'],
            'customer_contact' => ['required'],
            'customer_comment' => ['required'],
        ]);

        $order = new Order();
        $order->fill($validatedData);
        $order->save();

        $products = $this->fetchProductsFromCart($request);

        $order->products()->attach($request->session()->get('cart', []));
        $subject = "New Order";
        $to = config('mail.to.address');

        Mail::to($to)->send(new NewOrderMail(
                $subject,
                $products,
                $validatedData['customer_name'],
                $validatedData['customer_contact'],
                $validatedData['customer_comment'])
        );

        $request->session()->put('cart', []);

        $message = 'Your order has been placed';
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }
}
