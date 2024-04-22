<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function addProduct()
    {
        return view('addProduct');
    }

    public function edit(Request $request)
    {
        $id = $request->input('productId');
        $product = Product::findById($id);
        if (!$product) {
            abort(404);
        }
        return view('product', compact('product'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'sometimes'],
            'description' => ['required', 'sometimes'],
            'price' => ['required', 'numeric', 'sometimes'],
            'img_link' => ['image', 'sometimes'],
        ]);

        Product::updateProduct($request);
        session()->flash('success', 'The product was successfully updated');
        return redirect()->route('products');
    }

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

    public function allProducts()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }

    public function deleteProduct(Request $request): RedirectResponse
    {
        $id = $request->input('productId');

        Product::destroy($id);

        session()->flash('success', 'The product was successfully deleted');

        return redirect()->route('products');
    }

    public function handleAddProduct(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'img_link' => ['required', 'image'],
        ]);

        $imageName = uniqid() . '.' . $request->file('img_link')->getClientOriginalExtension();
        $request->file('img_link')->storeAs('public/images', $imageName);

        $product = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'img_link' => $imageName,
        ];

        Product::addProduct($product);

        session()->flash('success', 'The product was successfully added');

        return redirect()->route('products');
    }
}
