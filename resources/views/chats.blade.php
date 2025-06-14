@extends('layouts.sharedlayout')

@section('title', 'Chats')
@section('styles')
<style>
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 0 0.5rem;
    }

    .admin-avatar {
        background: #047705;
        color: white;
    }

    .student-avatar {
        background: #EDD100;
        color: black;
    }

    .message-content {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
    }

    .admin-message {
        background: rgba(4, 119, 5, 0.3);
        border-top-right-radius: 0;
    }

    .student-message {
        background: rgba(255, 255, 255, 0.1);
        border-top-left-radius: 0;
    }
    /* Scrollbar styling */
    .messages-container::-webkit-scrollbar {
        width: 6px;
    }

    .messages-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    .messages-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    /* Firefox support */
    .messages-container {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.05);
    }
</style>
@endsection

@section('content')
<div  class=" content-section flex mx-10 justify-center  min-h-full">
    <div  class="bg-gradient-to-r p-6 from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px]  mt-32 w-[100%] mb-10 h-full backdrop-blur-sm flex flex-col">
            <div class="w-[100%] h-[780px]">
                <div class="liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Enhanced Cart Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">Chat with Admin</h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    <!-- Chat Messages -->
                    <div id="chat-container" class="messages-container h-[560px] overflow-y-auto mb-4 space-y-4">
                        @foreach($chats as $chat)
                            @if($chat->sent_by === 'admin')
                                <!-- Admin Message -->
                                <div class="flex justify-start">
                                    <div class="flex items-end max-w-[70%]">
                                        <div class="avatar admin-avatar mr-2 w-8 h-8 flex items-center justify-center">
                                            A
                                        </div>
                                        <div class="message-content admin-message text-white">
                                            <span class="block text-m">{{ $chat->message }}</span>
                                            <span class="block text-[10px] text-gray-300">{{ $chat->timestamp->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Student Message -->
                                <div class="flex justify-end">
                                    <div class="flex items-end max-w-[70%]">
                                        <div class="message-content student-message text-white">
                                            <span class="block text-m">{{ $chat->message }}</span>
                                            <span class="block text-[10px] text-gray-300">{{ $chat->timestamp->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <div class="avatar student-avatar ml-2 w-8 h-8 flex items-center justify-center">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                        <!-- Suggested Messages -->
                        <div class="flex flex-wrap gap-2 ms-2 mb-4">
                            @php
                                $suggestedMessages = [
                                    "Hello Admin, I need help with my order.",
                                    "Payment sent, this is my GCash Receipt",
                                    "Can you assist me with my enrollment?",
                                    "I have a concern about my order..",
                                    "Thank you for your assistance!"
                                ];
                            @endphp

                            @foreach ($suggestedMessages as $msg)
                                <button type="button"
                                        onclick="setSuggestedMessage(`{{ $msg }}`)"
                                        class="bg-white/20 text-white px-3 py-1 rounded-full text-sm hover:bg-white/30 transition">
                                    {{ $msg }}
                                </button>
                            @endforeach
                        </div>
                    <form id="chat-form" action="{{ route('student.chat.send') }}" method="POST" class="flex items-center space-x-2">
                        
                        @csrf
                        <input id="message-input" type="text" name="message" placeholder="Type your message..." class="flex-1 p-2 rounded-lg bg-white/20 text-white focus:outline-none" required>
                        <button type="submit" class="bg-[#047705] text-white px-4 py-2 rounded-lg">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('uniforms.modals')

<script>
    function setSuggestedMessage(message) {
        const input = document.getElementById('message-input');
        input.value = message;
        input.focus();
    }

    // Optional: scroll to bottom on page load
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('chat-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatContainer = document.getElementById('chat-container');

    // ✅ Scroll to bottom AFTER the page fully loads
    window.addEventListener('load', function () {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        if (!message) return;

        fetch(chatForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => {
            // Build HTML string for student message
            const messageHtml = `
                <div class="flex justify-end">
                    <div class="flex items-end max-w-[70%]">
                        <div class="message-content student-message text-white">
                            <span class="block text-sm">${data.message}</span>
                            <span class="block text-[10px] text-gray-300">${data.timestamp}</span>
                        </div>
                        <div class="avatar student-avatar ml-2 w-8 h-8 flex items-center justify-center">
                            ${data.initials}
                        </div>
                    </div>
                </div>
            `;

            chatContainer.insertAdjacentHTML('beforeend', messageHtml);
            messageInput.value = '';
            chatContainer.scrollTop = chatContainer.scrollHeight;
        })
        .catch(err => console.error('Message failed to send:', err));
    });
</script>

@endsection