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
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
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
            $query->whereHas('statusHistories', function ($q) use ($status) {
                $q->where('status', $status)
                  ->whereIn('history_id', function ($subQuery) {
                      $subQuery->selectRaw('MAX(history_id)')
                               ->from('order_history')
                               ->groupBy('order_id');
                  });
            });
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

        if (auth()->user()->role !== 'admin') {
            Log::warning('Unauthorized status update attempt', [
                'order_id' => $order->order_id,
                'user_id' => auth()->id(),
                'attempted_status' => $request->input('status')
            ]);
            abort(403, 'Unauthorized action');
        }

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

        $currentStatus = strtolower($order->current_status);
        $newStatus = strtolower($validated['status']);
        Log::debug('Current status retrieved', [
            'order_id' => $order->order_id,
            'current_status' => $currentStatus,
            'history_count' => $order->statusHistories()->count()
        ]);

        if (!$order->isValidStatusTransition($newStatus)) {
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

        if ($validated['status'] === 'paid') {
            try {
                $order->payment_status = 'paid';
                $order->save();

                \Log::info('Payment status updated to paid', [
                    'order_id' => $order->order_id,
                    'payment_status' => $order->payment_status
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to update payment status', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                    'current_payment_status' => $order->payment_status,
                    'attempted_status' => 'paid'
                ]);
                throw $e;
            }
        }

        // Send Email
        try {
            $student = $order->student;
            if ($student && !empty($student->email)) {
                $latestStatus = $validated['status'];
                $formatted = [
                    'order_id' => $order->order_id,
                    'status' => $latestStatus,
                    'student_name' => $student->name ?? 'Student',
                    'updated_at' => now()->toDateTimeString(),
                    'updated_by' => auth()->user()->name ?? 'System'
                ];

                Mail::to($student->email)->send(new NotificationMail($formatted));

                Log::info('Status change email sent to student', [
                    'order_id' => $order->order_id,
                    'email' => $student->email,
                    'status' => $latestStatus
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send status change email', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage()
            ]);
        }

        // ✅ Format Notification for return or logging
        $formattedNotification = $this->formatNotification($historyRecord);

        Log::info('Status update completed successfully', [
            'order_id' => $order->order_id,
            'new_status' => $validated['status'],
            'processing_time_ms' => microtime(true) - LARAVEL_START
        ]);

        return response()->json([
            'success' => true,
            'current_status' => $validated['status'],
            'order' => $order->load('statusHistories'),
            'notification' => $formattedNotification // <-- return it here
        ]);
    }

    private function formatNotification($history)
    {
        $status = strtolower($history->status);
        $statusMessages = [
            'pending' => "Your order #{$history->order_id} is pending confirmation.",
            'paid' => "Your order #{$history->order_id} payment has been confirmed.",
            'processing' => "Your order #{$history->order_id} is being processed.",
            'readyforpickup' => "Your order #{$history->order_id} is ready for pickup at the coop office.",
            'completed' => "Your order #{$history->order_id} has been completed.",
            'cancelled' => "Your order #{$history->order_id} has been cancelled."
        ];

        $statusTypes = [
            'Pending' => 'ORDER UPDATE',
            'Paid' => 'ORDER UPDATE',
            'Processing' => 'ORDER UPDATE',
            'ReadyForPickup' => 'ORDER UPDATE',
            'Completed' => 'ORDER UPDATE',
            'Cancelled' => 'ORDER UPDATE'
        ];

        $statusIcons = [
            'Pending' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'Paid' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'Processing' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'ReadyForPickup' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'Completed' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'Cancelled' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
        ];

        $statusColors = [
            'Pending' => '#EDD100',
            'Paid' => '#EDD100',
            'Processing' => '#EDD100',
            'ReadyForPickup' => '#EDD100',
            'Completed' => '#EDD100',
            'Cancelled' => '#EDD100'
        ];


        return [
            'history_id' => $history->history_id,
            'status' => $status,
            'type' => $statusTypes[$status] ?? 'ORDER UPDATE',
            'title' => "Order #{$history->order_id} Status Update",
            'message' => $statusMessages[$status] ?? "Order #{$history->order_id} status updated to {$status}.",
            'icon' => $statusIcons[$status] ?? '',
            'color' => $statusColors[$status] ?? '#EDD100',
            'time_ago' => $history->updated_at->diffForHumans(),
            'updated_at' => $history->updated_at->format('F j, Y g:i A'),
            'updated_by_name' => optional($history->user)->name ?? 'System'  // ✅ safe access
        ];
    }
    public function cancel(OrderModel $order)
    {
        Log::info('Cancel order attempt started', [
            'order_id' => $order->order_id,
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'current_status' => $order->current_status,
            'ip_address' => request()->ip()
        ]);

        if (auth()->user()->role !== 'admin') {
            Log::warning('Unauthorized attempt to cancel order', [
                'order_id' => $order->order_id,
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        if (!$order->isValidStatusTransition('cancelled')) {
            Log::warning('Invalid status transition to cancelled', [
                'order_id' => $order->order_id,
                'current_status' => $order->current_status,
                'allowed_transitions' => $order->getAllowedTransitions()
            ]);
            return response()->json([
                'success' => false,
                'message' => sprintf('Cannot cancel order from %s status', $order->current_status)
            ], 422);
        }

        try {
            $historyRecord = $order->recordStatusChange('cancelled', auth()->id());
            Log::info('Order status history recorded', [
                'order_id' => $order->order_id,
                'history_id' => $historyRecord->history_id,
                'new_status' => $historyRecord->status,
                'updated_by' => $historyRecord->updated_by,
                'updated_at' => $historyRecord->updated_at
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to cancel order', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
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
