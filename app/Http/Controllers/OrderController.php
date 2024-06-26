<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function all()
    {
        $orders = Order::query()->select('orders.id AS order_id', 'orders.created_at AS order_created_at')
            ->selectRaw('SUM(products.price) AS total_price')
            ->selectRaw('GROUP_CONCAT(products.title SEPARATOR ", ") AS product_titles')
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->groupBy('orders.id', 'orders.created_at')
            ->get();

        $data = compact('orders');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('orders', $data);
    }

    public function showOne(Request $request)
    {
        $orderId = $request->input('productId');

        $order = Order::query()->where('id', $orderId)->with('products')->firstOrFail();

        if (!$order) {
            $message = __('Invalid order id');
            return request()->isXmlHttpRequest() ?
                response()->json(['message' => $message],404) : redirect()->back()->withErrors(['message' => $message]);
        }

        $data = compact('order');

        return request()->isXmlHttpRequest() ?
            compact('data') : view('order', $data);
    }
}
