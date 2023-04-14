<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Retrieve all order items and return them as a JSON response
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'menuItem'])->get();
        return response()->json($orderItems);
    }

    // Validate the incoming request, create a new order item, and return a success message along with the created order item as a JSON response
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem = new OrderItem();
        $orderItem->order_id = $request->order_id;
        $orderItem->menu_item_id = $request->menu_item_id;
        $orderItem->quantity = $request->quantity;
        $orderItem->save();

        return response()->json(['message' => 'Order item created successfully', 'order_item' => $orderItem], 201);
    }

    // Retrieve a specific order item by their ID and return it as a JSON response
    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'menuItem']);
        return response()->json($orderItem);
    }

    // Validate the incoming request, update the specified order item, and return a success message along with the updated order item as a JSON response
    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        if ($request->has('quantity')) {
            $orderItem->quantity = $request->quantity;
        }

        $orderItem->save();

        return response()->json(['message' => 'Order item updated successfully', 'order_item' => $orderItem]);
    }

    // Delete the specified order item and return a success message as a JSON response
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(['message' => 'Order item deleted successfully']);
    }
}

