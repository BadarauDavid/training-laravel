<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add()
    {
        return view('addProduct');
    }

    public function handle(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'img_link' => ['required', 'image'],
        ]);

        $validatedData = $request->only(['title', 'description', 'price', 'img_link']);

        if ($request->hasFile('img_link')) {
            $imageName = uniqid() . '.' . $request->file('img_link')->getClientOriginalExtension();
            $request->file('img_link')->storeAs('public/images', $imageName);
            $validatedData['img_link'] = $imageName;
        }

        $id = $request->input('id');

        if ($id) {
            $product = Product::query()->findOrFail($id);
            $product->fill($validatedData);
            $product->save();
            $message = __('The product was successfully updated');
        } else {
            $newProduct = new Product();
            $newProduct->fill($validatedData);
            $newProduct->save();
            $message = __('The product was successfully added');
        }

        session()->flash('success', $message);

        return $request->isXmlHttpRequest() ?
            response()->json([$message]) : redirect()->route('products');
    }

    public function all()
    {
        $products = Product::query()->get();
        $data = compact('products');
        return request()->isXmlHttpRequest() ?
            compact('data') : view('products', $data);
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


    public function delete(Request $request)
    {
        $id = $request->input('productId');

        Product::query()->where('id', $id)->delete();

        $message = __('The product was successfully deleted');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json([$message]) : redirect()->route('products');
    }
}
