<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function allOrders()
    {
        $orders = Order::findAllOrders();

        return view('orders', compact('orders'));
    }

    public function showOrder(Request $request)
    {
        $order = Order::findOrderById($request->input('productId'));
        return view('order', compact('order'));
    }
}
