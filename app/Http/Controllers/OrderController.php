<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $status = request()->query('status', 'all');

        $query = OrderModel::with(['orderItems.uniform', 'student']); // corrected relationships
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Use 'order_date' instead of 'created_at'
        $orders = $query->orderByDesc('order_date')->get();

        if (request()->wantsJson()) {
            return response()->json($orders);
        }

        return view('orderManage', compact('orders'));
    }




    public function show(OrderModel $order)
    {
        $order->load([
            'orderItems.uniform', // assuming this relationship exists
            'student',
            'processedOrder'
        ]);

        return response()->json($order);
    }



    // Update order status (paid, processing, etc.)
    public function updateStatus(Request $request, OrderModel $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,processing,ready_for_pickup,completed,cancelled'
        ]);
        
        $order->update(['status' => $validated['status']]);
        
        return response()->json([
            'success' => true,
            'order' => $order->fresh()
        ]);
    }

    // Add a note to an order
    public function addNote(Request $request, OrderModel $order)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:500'
        ]);
        
        $note = $order->notes()->create([
            'admin_id' => auth()->id(),
            'content' => $validated['note']
        ]);
        
        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    // Cancel an order
    public function cancel(OrderModel $order)
    {
        $order->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }
}