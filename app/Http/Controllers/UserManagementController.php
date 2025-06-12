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
    public function index()
    {
        // Fetch students with their orders
        $students = StudentModel::with('orders')->get();

        return view('usermanage', compact('students'));
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

            // Delete related orders and their history
            foreach ($student->orders as $order) {
                // Delete order history
                $order->statusHistories()->delete();
                // Delete order items (if any)
                $order->orderItems()->delete();
                // Delete processed order (if any)
                $order->processedOrder()->delete();
                // Delete the order
                $order->delete();
            }

            // Delete related chats (if any)
            $student->chats()->delete();

            // Delete the student
            $student->delete();

            DB::commit();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }
}