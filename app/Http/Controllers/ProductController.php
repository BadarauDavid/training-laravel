<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $imgLinkFile = $request->file('img_link');
        $id = $request->input('id');

        if ($request->hasFile('img_link')) {
            $imageName = uniqid() . '.' . $imgLinkFile->getClientOriginalExtension();
            $validatedData['img_link'] = $imageName;
        }

        if ($id) {
            $product = Product::query()->findOrFail($id);
            $product->fill($validatedData);
            $productSaved = $product->save();
            $message = __('The product was successfully updated');
        } else {
            $newProduct = new Product();
            $newProduct->fill($validatedData);
            $productSaved = $newProduct->save();
            $message = __('The product was successfully added');
        }

        if ($productSaved && $imgLinkFile) {
            $imgLinkFile->storeAs('public/images', $imageName);
        } elseif (!$productSaved && $imgLinkFile) {
            Storage::delete('public/images/' . $imageName);
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
