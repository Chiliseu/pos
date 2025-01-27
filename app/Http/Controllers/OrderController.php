<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Fetch all orders
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    // Fetch a single order
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    // Create a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'OrderDate' => 'required|date',
            'Subtotal' => 'nullable|numeric',
            'Total' => 'nullable|numeric',
        ]);

        // Generate a unique identifier in the format ORD-Random
        $validated['UniqueIdentifier'] = strtoupper('ORD-' . Str::random(5)); // Random 8-character string

        // Create the order with the validated data
        $order = Order::create($validated);

        // Return the created order with the OrderID
        return response()->json($order, 201);
    }

    // Update an existing order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'OrderDate' => 'nullable|date',
            'Subtotal' => 'nullable|numeric',
            'Total' => 'nullable|numeric',
        ]);

        $order->update($validated);
        return response()->json($order, 200);
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Order deleted'], 200);
    }

    public function getNewestOrderId()
    {
        // Attempt to fetch the latest order
        $latestOrder = Order::latest()->first();

        // Check if an order was found
        if ($latestOrder) {
            return response()->json([
                'orderId' => $latestOrder->OrderID, // Use OrderID from migration
            ]);
        } else {
            return response()->json([
                'orderId' => null,
            ]);
        }
    }
}
