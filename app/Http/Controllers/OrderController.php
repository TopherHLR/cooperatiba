<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Facades\Activity;

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
        $latestStatus = $order->statusHistories->sortByDesc('updated_at')->first()?->status ?? $order->status;

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
        Log::info('Status update initiated', [
            'order_id' => $order->order_id,
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'requested_status' => $request->input('status'),
            'ip_address' => $request->ip()
        ]);

        // Verify admin access
        if (auth()->user()->role !== 'admin') {
            Log::warning('Unauthorized status update attempt', [
                'order_id' => $order->order_id,
                'user_id' => auth()->id(),
                'attempted_status' => $request->input('status')
            ]);
            abort(403, 'Unauthorized action');
        }

        // Validate input
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,paid,processing,readyforpickup,completed,cancelled'
            ]);
            Log::debug('Status validation passed', [
                'order_id' => $order->order_id,
                'validated_status' => $validated['status']
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Status validation failed', [
                'order_id' => $order->order_id,
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        }

        // Get current status with debug logging
        $currentStatus = $order->current_status;
        Log::debug('Current status retrieved', [
            'order_id' => $order->order_id,
            'current_status' => $currentStatus,
            'history_count' => $order->statusHistories()->count()
        ]);

        // Check valid transition
        if (!$order->isValidStatusTransition($validated['status'])) {
            Log::warning('Invalid status transition attempted', [
                'order_id' => $order->order_id,
                'current_status' => $currentStatus,
                'attempted_status' => $validated['status'],
                'allowed_transitions' => $order->getAllowedTransitions()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => sprintf('Cannot change status from %s to %s', $currentStatus, $validated['status'])
            ], 422);
        }

        // Record the change
        try {
            $historyRecord = $order->recordStatusChange($validated['status'], auth()->id());
            Log::info('Status change recorded', [
                'order_id' => $order->order_id,
                'new_status' => $validated['status'],
                'history_id' => $historyRecord->history_id,
                'updated_by' => auth()->id()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to record status change', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
        // Update payment status if needed
        if ($validated['status'] === 'paid') {
            try {
                // Explicitly set the payment status using the model's attribute
                $order->payment_status = 'paid';
                
                // Save the model (this will properly escape/quote the value)
                $order->save();
                
                \Log::info('Payment status updated to paid', [
                    'order_id' => $order->order_id,
                    'payment_status' => $order->payment_status // log the actual value
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update payment status', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                    'current_payment_status' => $order->payment_status,
                    'attempted_status' => 'paid'
                ]);
                throw $e; // Consider re-throwing if you want the API to return the error
            }
        }

        Log::info('Status update completed successfully', [
            'order_id' => $order->order_id,
            'new_status' => $validated['status'],
            'processing_time_ms' => microtime(true) - LARAVEL_START
        ]);

        return response()->json([
            'success' => true,
            'current_status' => $validated['status'],
            'order' => $order->load('statusHistories')
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
