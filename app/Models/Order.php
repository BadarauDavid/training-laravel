<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_contact',
        'customer_comment',
    ];

    public static function create(array $validatedData): Order
    {
        $newOrder = new Order();
        $newOrder->fill($validatedData);
        $newOrder->save();

        return $newOrder;
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

    public static function findAllOrders()
    {
        return DB::table('orders')
            ->select('orders.id AS order_id', 'orders.created_at AS order_created_at',
                DB::raw('SUM(products.price) AS total_price'),
                DB::raw('GROUP_CONCAT(products.title SEPARATOR ", ") AS product_titles'))
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->groupBy('orders.id', 'orders.created_at')
            ->get();
    }
}
