<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $totalPrice = 0;
        foreach ($request->order_items as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
        ]);

        foreach ($request->order_items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => Product::find($item['product_id'])->price,
            ]);
        }

        return response()->json($order->load('orderItems.product'), 201);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('orderItems.product'));
    }


    public function getOrdersWithUsersAndItems()
{
    $orders = Order::with(['user', 'orderItems.product'])->get();

    $orders = $orders->map(function ($order) {
        $order->user_name = $order->user->name;
        return $order;
    });

    return response()->json($orders);
}

public function countOrders()
{
    $count = Order::count();
    return response()->json(['count' => $count]);
}
}
