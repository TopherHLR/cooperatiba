<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $status = request()->query('status', 'all');

        $query = OrderModel::with(['orderItems.uniform', 'student'])
            ->orderByDesc('order_date');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        if (request()->wantsJson()) {
            return response()->json($orders);
        }

        return view('orderManage', compact('orders'));
    }

    public function show(OrderModel $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $order->load([
            'orderItems.uniform',
            'student',
            'processedOrder',
            'statusHistories.user'
        ]);

        // Get the latest status from the statusHistories relation
        $latestStatus = $order->statusHistories->sortByDesc('created_at')->first()?->status ?? $order->status;

        // Add a custom property to the response (without mutating the model)
        $orderData = $order->toArray();
        $orderData['latest_status'] = $latestStatus;

        // Log for debugging
        Log::info('Order Show Debug:', [
            'order_id' => $order->order_id ?? $order->id,
            'latest_status' => $latestStatus,
            'statusHistories' => $order->statusHistories,
            'orderData' => $orderData
        ]);

        return response()->json($orderData, 200, [], JSON_PRETTY_PRINT);
    }


    public function updateStatus(Request $request, OrderModel $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,processing,ready_for_pickup,completed,cancelled'
        ]);

        if (!$order->isValidStatusTransition($validated['status'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition'
            ], 422);
        }

        $order->update(['status' => $validated['status']]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->withProperties(['status' => $validated['status']])
            ->log('status_updated');

        return response()->json([
            'success' => true,
            'order' => $order->fresh()
        ]);
    }

    public function cancel(OrderModel $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($order->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel a completed order'
            ], 422);
        }

        $order->update(['status' => 'cancelled']);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->log('order_cancelled');

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }

    public function statistics()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return response()->json([
            'data' => OrderModel::getDashboardStatistics()
        ]);
    }
}
