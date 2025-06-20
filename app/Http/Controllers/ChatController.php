<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatModel;
use App\Models\User;
use App\Models\StudentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this at the top if not already imported
class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Only allow students to access this route
        if (!$user || $user->role !== 'student') {
            abort(403, 'Unauthorized access.');
        }

        // Get the associated student model
        $student = $user->student;

        // Count unread messages sent by admin
        $chatCount = ChatModel::where('student_id', $student->user_id)
            ->where('sent_by', 'admin')
            ->where('is_read', false)
            ->count();

        // Mark all unread messages from admin as read
        ChatModel::where('student_id', $student->user_id)
            ->where('sent_by', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Fetch all chats
        $chats = ChatModel::with(['admin', 'student'])
            ->where('student_id', $student->user_id)
            ->orderBy('timestamp', 'asc')
            ->get();

        return view('chats', compact('chats', 'student', 'chatCount'));
    }

    public function sendMessage(Request $request)
    {

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $user = Auth::user();
            $student = $user->student;

            if (!$student) {
                return response()->json(['error' => 'Student record not found.'], 404);
            }

            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                return response()->json(['error' => 'No admin available'], 500);
            }

            $chat = ChatModel::create([
                'student_id' => $student->user_id,
                'admin_id' => $admin->id,
                'sent_by' => 'student',
                'message' => $request->message,
                'timestamp' => now(),
                'is_read' => false,
            ]);


            return response()->json([
                'message' => $chat->message,
                'timestamp' => $chat->timestamp->format('M d, Y h:i A'),
                'initials' => substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending message.', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'An error occurred while sending the message.'], 500);
        }
    }
}
