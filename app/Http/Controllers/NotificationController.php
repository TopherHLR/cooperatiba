<?php

namespace App\Http\Controllers;

use App\Models\OrderHistoryModel;
use App\Models\OrderModel;
use App\Models\StudentModel; // Make sure you import the Student model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Fetch notifications for the authenticated user
     */

    public function getNotifications(Request $request)
    {
        // Log entry point
        Log::info('getNotifications method called', ['user_id' => Auth::id()]);

        // Get the authenticated user
        $user = Auth::user();

        // Fetch student_id from student table using user_id
        $student = StudentModel::where('user_id', $user->id)->first();

        if (!$student) {
            Log::warning('No student record found for user', ['user_id' => $user->id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Student record not found.'
            ], 404);
        }

        $studentId = $student->student_id;
        Log::info('Student ID resolved', ['student_id' => $studentId]);

        // Fetch order histories for this student
        $notifications = OrderHistoryModel::query()
            ->select(
                'order_history.history_id',
                'order_history.order_id',
                'order_history.status',
                'order_history.updated_at',
                'order_history.updated_by',
                'users.name as updated_by_name'
            )
            ->join('order', 'order_history.order_id', '=', 'order.order_id')
            ->join('users', 'order_history.updated_by', '=', 'users.id')
            ->where('order.student_id', $studentId)
            ->orderBy('order_history.updated_at', 'desc')
            ->get()
            ->map(function ($history) {
                return $this->formatNotification($history);
            });

        Log::info('Notifications retrieved', ['count' => count($notifications)]);

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }
    /**
     * Format a single notification
     */
    private function formatNotification($history)
    {
        $statusMessages = [
            'Pending' => "Your order #{$history->order_id} is pending confirmation.",
            'Paid' => "Your order #{$history->order_id} payment has been confirmed.",
            'Processing' => "Your order #{$history->order_id} is being processed.",
            'ReadyForPickup' => "Your order #{$history->order_id} is ready for pickup at the coop office.",
            'Completed' => "Your order #{$history->order_id} has been completed.",
            'Cancelled' => "Your order #{$history->order_id} has been cancelled."
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
            'type' => $statusTypes[$history->status] ?? 'ORDER UPDATE Etc.',
            'title' => "Order #{$history->order_id} Status Update",
            'message' => $statusMessages[$history->status] ?? "Order #{$history->order_id} status updated to {$history->status}.",
            'icon' => $statusIcons[$history->status],
            'color' => $statusColors[$history->status],
            'time_ago' => $history->updated_at->diffForHumans(),
            'updated_by' => $history->updated_by_name
        ];
    }
}