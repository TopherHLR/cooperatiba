@extends('adminslayout')

@section('title', 'User Management')

@section('styles')
<style>
    /* Import Jost font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
  
    /* Apply Jost to all regular text elements */
    body, 
    p,
    ul, 
    li,
    a:not(.navbar-brand), /* Exclude specific elements if needed */
    button {
      font-family: 'Jost', sans-serif;
    }
    /* Liquid UI Background Effects */
    body {
        background: linear-gradient(135deg, #1F1E1E 0%, #001C00 100%);
        min-height: 100vh;
        font-family: 'Inria Sans', sans-serif;
        overflow-x: hidden;
    }
    
    /* Enhanced Moving Background */
    body::before {
        content: '';
        position: fixed;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            to bottom right,
            rgba(18, 108, 7, 0.15) 0%,          /* #126C07 */
            rgba(113, 200, 98, 0.15) 25%,        /* #71C862 */
            rgba(210, 220, 50, 0.12) 50%,        /* New yellowish tone */
            rgba(113, 200, 98, 0.15) 75%,        /* #71C862 */
            rgba(10, 56, 14, 0.15) 100%          /* #0A380E */
        );
        transform: rotate(30deg);
        animation: liquidFlow 15s linear infinite;
        z-index: -1;
        opacity: 0.5;
    }
    
    @keyframes liquidFlow {
        0% { transform: rotate(30deg) translate(-10%, -10%); }
        50% { transform: rotate(30deg) translate(10%, 10%); }
        100% { transform: rotate(30deg) translate(-10%, -10%); }
    }
    
    .liquid-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        background: rgba(31, 30, 30, 0.7);
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
        transition: all 0.5s ease;
    }
    
    .liquid-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(4, 119, 5, 0.1) 0%,
            rgba(237, 209, 0, 0.1) 50%,
            rgba(4, 119, 5, 0.1) 100%
        );
        animation: cardShine 8s ease infinite;
        z-index: -1;
    }
    
    @keyframes cardShine {
        0% { opacity: 0.3; }
        50% { opacity: 0.1; }
        100% { opacity: 0.3; }
    }
    
    .liquid-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
        background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
        box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
    }
    
    .liquid-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.6s ease;
    }
    
    .liquid-btn:hover::before {
        left: 100%;
    }
    
    .liquid-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .liquid-input:focus {
        border-color: #047705;
        box-shadow: 0 0 0 2px rgba(4, 119, 5, 0.3);
    }

    /* Content section with transparent background */
    .content-section {
        background-color: transparent;
    }
    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }

    /* Admin specific styles */
    .admin-action-btn {
        transition: all 0.2s ease;
    }
    
    .admin-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #047705;
    }
    
    .variant-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 5px;
        margin-bottom: 5px;
    }
        /* Updated Table Styles */
        .liquid-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: rgba(31, 30, 30, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
    }
    
    .liquid-table thead {
        background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
    }
    
    .liquid-table th {
        padding: 12px 16px;
        text-align: left;
        color: white;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .liquid-table td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.9);
    }
    
    .liquid-table tr:last-child td {
        border-bottom: none;
    }
    
    .liquid-table tr:hover td {
        background: rgba(4, 119, 5, 0.1);
    }
    
    /* Updated Modal Styles */
    .liquid-modal {
        background: rgba(31, 30, 30, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .liquid-modal::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(4, 119, 5, 0.1) 0%,
            rgba(237, 209, 0, 0.1) 50%,
            rgba(4, 119, 5, 0.1) 100%
        );
        animation: cardShine 8s ease infinite;
        z-index: -1;
        border-radius: 20px;
    }
    
    .liquid-modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
    }
    
    .liquid-modal-title {
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
        text-shadow: -1px 1px 0px #047705;
    }
    
    .liquid-modal-body {
        padding: 20px;
    }
    
    .liquid-modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    /* Form Input Styles */
    .liquid-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 14px;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .liquid-input:focus {
        outline: none;
        border-color: #047705;
        box-shadow: 0 0 0 2px rgba(4, 119, 5, 0.3);
        background: rgba(255, 255, 255, 0.08);
    }
    
    .liquid-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    
    .liquid-label {
        display: block;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
    }
    
    /* Button Styles */
    .modal-liquid-btn {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .modal-liquid-btn-primary {
        background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
    }
    
    .modal-liquid-btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .modal-liquid-btn-danger {
        background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(211, 47, 47, 0.4);
    }
    
    .modal-liquid-btn:hover {
        transform: translateY(-2px);
    }
    
    .modal-liquid-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.6s ease;
    }
    
    .modal-liquid-btn:hover::before {
        left: 100%;
    }
    
    /* Image Preview */
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #047705;
    }
    
    /* Variant Badges */
    .variant-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 5px;
        margin-bottom: 5px;
        background: rgba(4, 119, 5, 0.2);
        color: #71C862;
        border: 1px solid rgba(113, 200, 98, 0.3);
    }
    
    /* Form Group */
    .form-group {
        margin-bottom: 20px;
    }
</style>
@endsection
@section('admin-content')
<!-- User Management Table -->
<div class="overflow-x-auto">
    <div class="h-[750px]">
        <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">USER MANAGEMENT</h2>
            </div>
            <hr class="border-[.5px] border-white mb-6 -mx-6">
            <!-- Table Header -->
            <div class="mb-3">
                <table class="liquid-table w-full">
                    <thead class="bg-[#1F1E1E]">
                        <tr>
                            <th>Avatar</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Order Count</th>
                            <th>Activity Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Scrollable Table Body -->
            <div class="overflow-y-auto" style="max-height: 600px;">
                <table class="liquid-table w-full">
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Default Profile">
                                </div>
                            </td>
                            <td>{{ $student->user_id }}</td>
                            <td class="font-medium">{{ $student->first_name }} {{ $student->middle_initial ? $student->middle_initial . '.' : '' }} {{ $student->last_name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->program }}</td>
                            <td>{{ $student->orders->count() }}</td>
                            <td>
                                @php
                                    $latestOrder = $student->orders->sortByDesc('order_date')->first();
                                    $now = now();

                                    if ($latestOrder && $latestOrder->order_date >= $now->copy()->subYear()) {
                                        $status = 'Active';
                                        $badgeClass = 'bg-green-500';
                                    } else {
                                        if ($latestOrder) {
                                            $yearsInactive = $latestOrder->order_date->diffInYears($now);
                                            $status = 'Inactive for ' . $yearsInactive . ' year' . ($yearsInactive > 1 ? 's' : '');
                                        } else {
                                            $status = 'Inactive (No Orders)';
                                        }
                                        $badgeClass = 'bg-red-500';
                                    }
                                @endphp

                                <span class="variant-badge {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="font-medium">
                                <a href="{{ route('admin.chat.show', $student->user_id) }}" class="text-blue-300 hover:text-blue-100 admin-action-btn">
                                    Message
                                </a>
                                <button onclick="confirmDelete('{{ $student->user_id }}')" class="text-red-300 hover:text-red-100 admin-action-btn">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>      
</div>
<script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            axios.delete(`/users/${userId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                alert(response.data.message);
                window.location.reload(); // Refresh the page to update the table
            })
            .catch(error => {
                alert(error.response.data.message || 'An error occurred while deleting the user.');
            });
        }
    }
</script>
@endsection
