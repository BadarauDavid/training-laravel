<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function addProduct()
    {
        return view('addProduct');
    }

    public function edit(Request $request)
    {
        $id = $request->input('productId');
        $product = Product::query()->findOrFail($id);
        if (!$product) {
            abort(404);
        }

        $data = compact('product');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('product', $data);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'sometimes'],
            'description' => ['required', 'sometimes'],
            'price' => ['required', 'numeric', 'sometimes'],
            'img_link' => ['image', 'sometimes'],
        ]);

        $id = $request->input('id');

        $product = Product::query()->findOrFail($id);
        $product->fill($validatedData);

        if ($request->hasFile('img_link')) {
            $imageName = uniqid() . '.' . $request->file('img_link')->getClientOriginalExtension();
            $request->file('img_link')->storeAs('public/images', $imageName);
            $product->setAttribute('img_link', $imageName);
        }

        $product->save();

        $message = 'The product was successfully updated';
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => 'The product was successfully updated']) : redirect()->route('products');
    }

    public function allProducts()
    {
        $products = Product::query()->get();
        $data = compact('products');
        return request()->isXmlHttpRequest() ?
            compact('data') : view('products', $data);
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->input('productId');

        Product::query()->where('id', $id)->delete();

        $message = 'The product was successfully deleted';
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('products');
    }

    public function handleAddProduct(Request $request)
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

        $newProduct = new Product();
        $newProduct->fill($product);
        $newProduct->save();

        $message = 'The product was successfully added';
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('products');
    }
}
