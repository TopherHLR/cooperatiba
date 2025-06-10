<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get orders for the authenticated student user
        $orders = OrderModel::where('student_id', $user->student_id)
            ->with([
                'orderItems.uniform',
                'processedOrder',
                'statusHistories' => function($query) {
                    $query->latest('updated_at');
                }
            ])
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function($order) {
                // Add latest_status to each order
                $order->latest_status = $order->statusHistories->first()->status ?? 'pending';
                return $order;
            });

        return response()->json([
            'orders' => $orders,
            'status_counts' => $this->getStatusCounts($orders)
        ]);
    }

    /**
     * Display the specified order for the authenticated user.
     */
    public function show($orderId)
    {
        $user = Auth::user();
        
        $order = OrderModel::with([
                'orderItems.uniform',
                'student',
                'processedOrder',
                'statusHistories.user' => function($query) {
                    $query->orderBy('updated_at', 'desc');
                }
            ])
            ->where('order_id', $orderId)
            ->where('student_id', $user->student_id)
            ->firstOrFail();

        // Get the latest status
        $latestStatus = $order->statusHistories->first()->status ?? 'pending';

        // Transform the order data for frontend
        $orderData = [
            'order_id' => $order->order_id,
            'order_number' => 'COOP-' . date('Y', strtotime($order->order_date)) . '-' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT),
            'total_price' => $order->total_price,
            'order_date' => $order->order_date,
            'latest_status' => $latestStatus,
            'status_class' => $this->getStatusClass($latestStatus),
            'items' => $order->orderItems->map(function($item) {
                return [
                    'name' => $item->uniform->name,
                    'size' => $item->size,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'image' => $item->uniform->image_url,
                    'total' => $item->price * $item->quantity
                ];
            }),
            'status_history' => $order->statusHistories->map(function($history) {
                return [
                    'status' => $history->status,
                    'formatted_status' => $this->formatStatus($history->status),
                    'updated_by' => $history->user->name ?? 'System',
                    'updated_at' => $history->updated_at->format('M d, Y - h:i A')
                ];
            }),
            'processed_details' => $order->processedOrder ? [
                'processed_by' => $order->processedOrder->user->name,
                'processed_at' => $order->processedOrder->processed_at->format('M d, Y - h:i A'),
                'pickup_location' => $order->processedOrder->pickup_location,
                'estimated_pickup_date' => $order->processedOrder->estimated_pickup_date
                    ? $order->processedOrder->estimated_pickup_date->format('M d, Y')
                    : null,
                'actual_pickup_date' => $order->processedOrder->actual_pickup_date
                    ? $order->processedOrder->actual_pickup_date->format('M d, Y - h:i A')
                    : null
            ] : null
        ];

        return response()->json($orderData);
    }

    /**
     * Get counts of orders by status for the user.
     */
    private function getStatusCounts($orders)
    {
        return [
            'all' => $orders->count(),
            'pending' => $orders->where('latest_status', 'pending')->count(),
            'paid' => $orders->where('latest_status', 'paid')->count(),
            'processing' => $orders->where('latest_status', 'processing')->count(),
            'readyforpickup' => $orders->where('latest_status', 'readyforpickup')->count(),
            'completed' => $orders->where('latest_status', 'completed')->count(),
            'cancelled' => $orders->where('latest_status', 'cancelled')->count()
        ];
    }

    /**
     * Get CSS class for status display.
     */
    private function getStatusClass($status)
    {
        $classes = [
            'pending' => 'status-pending',
            'paid' => 'status-processing',
            'processing' => 'status-processing',
            'readyforpickup' => 'status-processing',
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled'
        ];

        return $classes[strtolower($status)] ?? 'status-pending';
    }

    /**
     * Format status for display.
     */
    private function formatStatus($status)
    {
        $formatted = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'processing' => 'Processing',
            'readyforpickup' => 'Ready for Pickup',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return $formatted[strtolower($status)] ?? $status;
    }
}