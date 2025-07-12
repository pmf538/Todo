<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['customer', 'orderItems.product'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        $order->load(['customer', 'orderItems.product']);

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['customer', 'orderItems.product']);
        
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => 'sometimes|in:pending,validated,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->only(['status', 'notes']));

        return response()->json([
            'success' => true,
            'message' => 'Commande mise à jour avec succès',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commande supprimée avec succès'
        ]);
    }

    /**
     * Validate an order and decrease stock.
     */
    public function validateOrder(Order $order): JsonResponse
    {
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les commandes en attente peuvent être validées'
            ], 400);
        }

        if ($order->validate()) {
            return response()->json([
                'success' => true,
                'message' => 'Commande validée avec succès',
                'data' => $order->fresh(['customer', 'orderItems.product'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de valider la commande. Vérifiez les stocks.'
        ], 400);
    }

    /**
     * Mark order as delivered.
     */
    public function markAsDelivered(Order $order): JsonResponse
    {
        if ($order->status !== 'validated') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les commandes validées peuvent être marquées comme livrées'
            ], 400);
        }

        if ($order->markAsDelivered()) {
            return response()->json([
                'success' => true,
                'message' => 'Commande marquée comme livrée',
                'data' => $order->fresh(['customer', 'orderItems.product'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors du marquage de la commande'
        ], 400);
    }

    /**
     * Get orders by customer.
     */
    public function getByCustomer(Customer $customer): JsonResponse
    {
        $orders = $customer->orders()->with(['orderItems.product'])->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
} 