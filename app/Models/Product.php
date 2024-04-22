<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'img_link',
    ];

    public static function addProduct(array $product)
    {
        $newProduct = new Product();
        $newProduct->fill($product);
        $newProduct->save();
    }

    public static function findById($id)
    {
        return DB::table('products')->where('id', $id)->first();
    }

    public function order(): BelongsToMany
    {

        return $this->belongsToMany(Order::class, 'order_product');
    }

    public static function updateProduct($request)
    {
        $id = $request->input('id');

        $product = Product::findById($id);
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('img_link')) {
            $imageName = uniqid() . '.' . $request->file('img_link')->getClientOriginalExtension();
            $request->file('img_link')->storeAs('public/images', $imageName);
            $product->img_link =  $imageName;
        }

        DB::table('products')
            ->where('id', $id)
            ->update(['title' => $product->title, 'description' => $product->description, 'price' => $product->price, 'img_link'=>$product->img_link]);

    }

}
