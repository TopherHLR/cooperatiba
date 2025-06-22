<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    /**
     * Display the user management page with students.
     */
    public function usermanage(Request $request)
    {
        // Fetch distinct programs for the filter dropdown
        $programs = StudentModel::select('program')->distinct()->pluck('program');

        // Start building the query
        $query = StudentModel::with('orders');

        // Search filter (name or email)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        // Program filter
        if ($program = $request->input('program')) {
            $query->where('program', $program);
        }

        // Activity status filter
        if ($status = $request->input('status')) {
            $query->where(function ($q) use ($status) {
                if ($status === 'active') {
                    $q->whereHas('orders', function ($q) {
                        $q->where('order_date', '>=', now()->subYear());
                    });
                } elseif ($status === 'inactive') {
                    $q->whereDoesntHave('orders', function ($q) {
                        $q->where('order_date', '>=', now()->subYear());
                    })->orWhereDoesntHave('orders');
                }
            });
        }

        // Fetch filtered students
        $students = $query->get();

        return view('usermanage', compact('students', 'programs'));
    }

    /**
     * Delete a student and their related data.
     */
    public function destroy($user_id)
    {
        try {
            DB::beginTransaction();

            // Find the student
            $student = StudentModel::findOrFail($user_id);

            // Get the related user before deleting the student
            $user = $student->user;

            // Delete related orders and their history
            foreach ($student->orders as $order) {
                // Delete order history
                $order->statusHistories()->delete();
                // Delete order items (if any)
                $order->orderItems()->delete();
                // Delete processed order (if any)
                $order->processedOrder()?->delete();
                // Delete the order
                $order->delete();
            }

            // Delete related chats (if any)
            $student->chats()->delete();

            // Delete the student
            $student->delete();

            // Delete the user account from `users` table
            if ($user) {
                // Optional: Delete chats or other things related to User
                $user->orderHistoryUpdates()->delete();
                $user->chats()->delete();
                $user->delete();
            }

            DB::commit();

            return response()->json(['message' => 'User and student deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }
}