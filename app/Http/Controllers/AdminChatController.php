<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatModel;
use App\Models\User;
use App\Models\StudentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminChatController extends Controller
{
    public function show($studentId = null)
    {
        $admin = Auth::user();

        if (!$admin || $admin->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        Log::info('Admin accessing chat page', [
            'admin_id' => $admin->id,
            'student_id' => $studentId
        ]);
        
        $distinctStudentIds = ChatModel::where('admin_id', $admin->id)
            ->orWhereIn('student_id', function ($query) use ($admin) {
                $query->select('student_id')
                    ->from('chat')
                    ->where('admin_id', $admin->id);
            })
            ->pluck('student_id')
            ->unique()
            ->values();


        // Load student and latest message for each
        $studentChats = $distinctStudentIds->map(function ($studentId) use ($admin) {
            $latestMessage = ChatModel::where('student_id', $studentId)
                ->where(function ($query) use ($admin, $studentId) {
                    $query->where('admin_id', $admin->id)
                        ->orWhere(function ($q) use ($studentId) {
                            $q->where('student_id', $studentId)
                                ->where('sent_by', 'student');
                        });
                })
                ->orderByDesc('timestamp')
                ->first();

            $student = StudentModel::find($studentId);

            Log::debug('Latest message per student', [
                'student_id' => $studentId,
                'admin_id' => $admin->id,
                'message' => $latestMessage?->message,
                'timestamp' => $latestMessage?->timestamp,
                'sent_by' => $latestMessage?->sent_by,
            ]);

            return (object)[
                'student' => $student,
                'latestMessage' => $latestMessage,
            ];
        });

        // Handle AJAX
        if (request()->ajax() && $studentId) {
            $student = StudentModel::findOrFail($studentId);
            $chats = ChatModel::with(['admin', 'student'])
                ->where('student_id', $studentId)
                ->orderBy('timestamp', 'asc')
                ->get();

            Log::info('Loaded chats for student via AJAX', [
                'student_id' => $studentId,
                'chat_count' => $chats->count(),
            ]);

            return response()->json([
                'html' => view('admin.chat.chat-content', compact('student', 'chats'))->render()
            ]);
        }

        // Full page load
        if ($studentId) {
            $student = StudentModel::findOrFail($studentId);
            $chats = ChatModel::with(['admin', 'student'])
                ->where('student_id', $studentId)
                ->orderBy('timestamp', 'asc')
                ->get();

            Log::info('Loaded chats for student', [
                'student_id' => $studentId,
                'chat_count' => $chats->count(),
            ]);

            return view('admin.chat.show', compact('studentChats', 'student', 'chats'));
        }

        Log::info('Admin loaded chat view with no student selected');

        return view('admin.chat.index', [
            'studentChats' => $studentChats,
            'student' => null,
            'chats' => collect()
        ]);
    }

    public function sendMessage(Request $request, $studentId)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $admin = Auth::user();
        $student = StudentModel::findOrFail($studentId);

        ChatModel::create([
            'student_id' => $student->user_id,
            'admin_id' => $admin->id,
            'sent_by' => 'admin',
            'message' => $request->message,
            'timestamp' => now(),
        ]);

        if ($request->ajax()) {
            $chats = ChatModel::with(['admin', 'student'])
                ->where('student_id', $studentId)
                ->orderBy('timestamp', 'asc')
                ->get();
            return response()->json([
                'html' => view('admin.chat.chat-content', compact('student', 'chats'))->render()
            ]);
        }

        return redirect()->route('admin.chat.show', $studentId);
    }

}