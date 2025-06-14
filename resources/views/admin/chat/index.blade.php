@extends('adminslayout')

@section('title', 'Admin Chat')

@section('styles')
<style>
    .chat-container {
        display: grid;
        grid-template-columns: 30% 70%;
        gap: 1rem;
    }
    
    .student-list {
        background: rgba(31, 30, 30, 0.7);
        border-radius: 15px;
        padding: 1rem;
        overflow-y: auto;
    }
    
    .chat-area {
        display: flex;
        flex-direction: column;
        background: rgba(31, 30, 30, 0.7);
        border-radius: 15px;
        padding: 1rem;
        height: 100%; /* Ensure full height to support sticky positioning */
    }
    
    .messages-container {
        flex-grow: 1;
        overflow-y: auto;
        margin-bottom: 1rem;
        padding: 0.5rem;
        height: 550px; /* Constant height */
    }
    
    .student-card {
        position: relative;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.05);
        overflow: hidden;
        z-index: 1;
    }

    .student-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(4, 119, 5, 0.2), transparent);
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 0;
    }

    .student-card:hover::before {
        opacity: 1;
    }

    .student-card:hover {
        background: rgba(4, 119, 5, 0.1);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(4, 119, 5, 0.3);
    }

    .student-card.active {
        background: rgba(4, 119, 5, 0.2);
        box-shadow: 0 0 0 2px rgba(4, 119, 5, 0.4);
    }

    .student-card .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 9999px;
        background: linear-gradient(135deg, #047705, #0aad0a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 1rem;
        flex-shrink: 0;
        z-index: 1;
    }

    .student-card .student-info {
        z-index: 1;
    }

    .student-card .student-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .student-card .student-info p {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
        margin: 0.25rem 0 0;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #EDD100;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: black;
        font-weight: bold;
    }
    
    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .admin-avatar {
        background: #047705;
        color: white;
    }
    
    .message-content {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        max-width: 100%;
        word-wrap: break-word;
    }

    .student-message {
        background: rgba(255, 255, 255, 0.1);
        border-top-left-radius: 0;
        margin-right: auto;
    }

    .admin-message {
        background: rgba(4, 119, 5, 0.3);
        border-top-right-radius: 0;
        margin-left: auto;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 0.25rem;
        text-align: right;
    }
    
    .chat-header {
        display: flex;
        align-items: center;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .no-chat-selected {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: rgba(255, 255, 255, 0.5);
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
</style>
@endsection

@section('admin-content')
    <div class="chat-container text-white p-6 bg-gradient-to-r from-[#100E00]/10 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] ">
        <!-- Left Side - Student List -->
        <div class="student-list h-[750px] ">
            <h3 class="text-lg text-white font-semibold mb-4">Recent Chats</h3>

            @if($studentChats->count() > 0)
                <div class="space-y-2">
                    @foreach($studentChats as $chatInfo)
                        <div onclick="loadChat({{ $chatInfo->student->user_id }})"
                            class="student-card {{ $student && $student->user_id == $chatInfo->student->user_id ? 'active' : '' }}"
                            data-student-id="{{ $chatInfo->student->user_id }}">
                            
                            <div class="student-avatar">
                                {{ substr($chatInfo->student->first_name, 0, 1) }}{{ substr($chatInfo->student->last_name, 0, 1) }}
                            </div>
                            
                            <div class="student-info">
                                <div class="font-medium">{{ $chatInfo->student->first_name }} {{ $chatInfo->student->last_name }}</div>
                                <div class="text-xs text-gray-400 truncate">
                                    {{ $chatInfo->latestMessage ? Str::limit($chatInfo->latestMessage->message, 30) : 'No messages yet' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400">No chat history with students yet.</p>
            @endif
        </div>

        <!-- Right Side - Chat Area -->
        <div class="chat-area mr-6">
            <div id="chat-content">
                @if($student)
                    @include('admin.chat.chat-content')
                @else
                    <div class="no-chat-selected">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-lg">Select a student to start chatting</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


<script>
    function scrollToLatestMessage() {
        const container = document.querySelector('.messages-container');
        if (container) {
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 50); // delay ensures layout is rendered
        }
    }

    function loadChat(studentId) {
        // Remove active class from all student cards
        document.querySelectorAll('.student-card').forEach(card => card.classList.remove('active'));
        // Add active class to the clicked card
        document.querySelector(`.student-card[data-student-id="${studentId}"]`).classList.add('active');

        // Fetch chat content via AJAX
        fetch(`/admin/chats/${studentId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('chat-content').innerHTML = data.html;
            initChatForm(); // Re-bind form
            scrollToLatestMessage(); // Scroll to bottom after loading chat
        })
        .catch(error => {
            console.error('Error loading chat:', error);
        });
    }

    function initChatForm() {
        const form = document.querySelector('#chat-content form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const action = form.getAttribute('action');

            fetch(action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('chat-content').innerHTML = data.html;
                initChatForm(); // Re-bind form after response
                scrollToLatestMessage(); // Scroll to bottom after sending message
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        });
    }

    // Bind on initial page load
    document.addEventListener('DOMContentLoaded', () => {
        initChatForm();
        scrollToLatestMessage();
    });
</script>


@endsection