<div class="chat-header flex items-center mb-4">
    <div class="student-avatar mr-3 bg-green-600 text-white w-10 h-10 flex items-center justify-center rounded-full text-lg font-bold">
        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
    </div>
    <div>
        <h3 class="font-semibold text-white">{{ $student->first_name }} {{ $student->last_name }}</h3>
        <p class="text-xs text-gray-400">Student</p>
    </div>
</div>

<div class="messages-container">
    @foreach($chats as $chat)
        @if($chat->sent_by === 'admin')
            <!-- Admin Message (Right-aligned) -->
            <div class="flex justify-end mb-4">
                <div class="flex items-start max-w-[80%]">
                    <div class="message-content admin-message">
                        <div class="text-white">{{ $chat->message }}</div>
                        <div class="message-time">{{ $chat->timestamp->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="avatar admin-avatar ml-2">
                        A
                    </div>
                </div>
            </div>
        @else
            <!-- Student Message (Left-aligned) -->
            <div class="flex justify-start mb-4">
                <div class="flex items-start max-w-[80%]">
                    <div class="avatar student-avatar mr-2">
                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                    </div>
                    <div class="message-content student-message">
                        <div class="text-white">{{ $chat->message }}</div>
                        <div class="message-time">{{ $chat->timestamp->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
<div>
    <!-- Chat form -->
    <form action="{{ route('admin.chat.send', $student->user_id) }}" method="POST"
        class="flex items-center   mt-6 gap-2">
        @csrf
        <input type="text" name="message" placeholder="Type your message..."
            class="flex-1 p-3 rounded-lg bg-white/20 text-white focus:outline-none placeholder:text-white/50"
            required>
        <button type="submit"
                class=" admin-nav-btn bg-yellow-600 text-white px-4 py-3 rounded-lg hover:bg-yellow-700 transition">
            Send
    </form>
</div>


