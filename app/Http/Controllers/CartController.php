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
        $cartItems = $request->session()->get('cart', []);

        if (!empty($cartItems)) {
            $cartItems = collect($cartItems)->filter(function ($item) {
                return !is_null($item);
            })->values()->all();

            return Product::query()->whereIn('id', $cartItems)->get();
        }
        return [];
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
            $message = __('Product add successfully');
        } else {
            $message = __('Product already added to cart');
        }

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }

    public function deleteFromCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $productId = $request->input('productId');

        if (!is_numeric($productId) || !in_array($productId, $cart)) {
            $message = __('Invalid product or product not found in cart');
            return $request->isXmlHttpRequest() ?
                response()->json(['error' =>$message]) :
                redirect()->route('cart')->with('error', $message);
        }

        foreach ($cart as $key => $value) {
            if ($value == $productId) {
                unset($cart[$key]);
                break;
            }
        }

        $request->session()->put('cart', $cart);
        $message = __('Product removed from cart successfully');
        return $request->isXmlHttpRequest() ?
            response()->json(['success' => $message]) :
            redirect()->route('cart')->with('success', $message);
    }

    public function checkOutCart(Request $request)
    {
        $request->validate([
            'customer_name' => ['required'],
            'customer_contact' => ['required'],
            'customer_comment' => ['required'],
        ]);

        $validatedData = [
            'customer_name' => $request->input('customer_name'),
            'customer_contact' => $request->input('customer_contact'),
            'customer_comment' => $request->input('customer_comment'),
        ];

        $order = new Order();
        $order->fill($validatedData);
        $order->save();

        $products = $this->fetchProductsFromCart($request);

        foreach ($products as $product) {
            $existingProduct = Product::query()->where('id', $product['id'])->first();
            if ($existingProduct) {
                $order->products()->attach($existingProduct->id);
            }
        }

        $subject = __('New Order');
        $to = config('mail.to.address');

        Mail::to($to)->send(new NewOrderMail(
                $subject,
                $products,
                $validatedData['customer_name'],
                $validatedData['customer_contact'],
                $validatedData['customer_comment'])
        );

        $request->session()->forget('cart');

        $message = __('Your order has been placed');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }
}
