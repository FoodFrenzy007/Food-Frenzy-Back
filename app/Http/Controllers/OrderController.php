<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Retrieve all orders and return them as a JSON response
    public function index()
    {
        $orders = Order::with(['student', 'restaurant'])->get();
        return response()->json($orders);
    }

    // Validate the incoming request, create a new order, and return a success message along with the created order as a JSON response
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'order_status' => 'required|in:Pending,In Progress,Completed,Canceled',
        ]);

        $order = new Order();
        $order->student_id = $request->student_id;
        $order->restaurant_id = $request->restaurant_id;
        $order->order_status = $request->order_status;
        $order->save();

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }

    // Retrieve a specific order by their ID and return it as a JSON response
    public function show(Order $order)
    {
        $order->load(['student', 'restaurant']);
        return response()->json($order);
    }

    // Validate the incoming request, update the specified order, and return a success message along with the updated order as a JSON response
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'sometimes|required|in:Pending,In Progress,Completed,Canceled',
        ]);

        if ($request->has('order_status')) {
            $order->order_status = $request->order_status;
        }

        $order->save();

        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
    }

    // Delete the specified order and return a success message as a JSON response
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
