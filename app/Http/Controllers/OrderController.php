<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'payment_method' => 'required|string',
            'item_name'      => 'required|string|max:255',
            'quantity'       => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
        ]);

        Order::create([
            'customer_name'  => $request->customer_name,
            'payment_method' => $request->payment_method,
            'item_name'      => $request->item_name,
            'quantity'       => $request->quantity,
            'price'          => $request->price,
            'total_amount'   => $request->quantity * $request->price,
        ]);

        return redirect()->route('admin.orders')->with('success', 'Order saved successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
    }
}