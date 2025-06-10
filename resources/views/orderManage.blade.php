@extends('adminslayout')

@section('title', 'Order Management')

@section('styles')
<style>
    /* Import Jost font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
    
    /* Apply Jost to all regular text elements */
    body, 
    p,
    ul, 
    li,
    a:not(.navbar-brand),
    button {
        font-family: 'Jost', sans-serif;
    }
    
    /* Admin-specific status colors */
    .admin-status-pending {
        color: #EDD100;
        background-color: rgba(237, 209, 0, 0.1);
    }
    
    .admin-status-processing {
        color: #047705;
        background-color: rgba(4, 119, 5, 0.1);
    }
    
    .admin-status-shipped {
        color: #3B82F6;
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .admin-status-completed {
        color: #10B981;
        background-color: rgba(16, 185, 129, 0.1);
    }
    
    .admin-status-cancelled {
        color: #EF4444;
        background-color: rgba(239, 68, 68, 0.1);
    }
    
    /* Admin Tracking Steps */
    .admin-step-container {
        position: relative;
        display: flex;
        align-items: flex-start;
    }
    
    .admin-step-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 16px;
        position: relative;
        z-index: 2;
    }
    
    .admin-step-icon svg {
        width: 20px;
        height: 20px;
    }
    
    .admin-step-content {
        flex: 1;
        padding-top: 4px;
    }
    
    /* Active step styling */
    .admin-step-container.active .admin-step-icon {
        border-color: #047705;
        background-color: #047705;
    }
    
    .admin-step-container.active .admin-step-current {
        display: block;
        color: white;
    }
    
    /* Completed step styling */
    .admin-step-container.completed .admin-step-icon {
        border-color: #047705;
        background-color: #047705;
    }
    
    .admin-step-container.completed .admin-step-check {
        display: block;
        color: white;
    }
    
    .admin-step-container.completed .admin-step-current {
        display: none;
    }
    
    /* Approval buttons */
    .approve-btn {
        background-color: rgba(16, 185, 129, 0.2);
        color: #10B981;
        border: 1px solid #10B981;
        transition: all 0.3s ease;
    }
    
    .approve-btn:hover {
        background-color: rgba(16, 185, 129, 0.4);
    }
    
    .reject-btn {
        background-color: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid #EF4444;
        transition: all 0.3s ease;
    }
    
    .reject-btn:hover {
        background-color: rgba(239, 68, 68, 0.4);
    }
    
    /* Admin action panel */
    .admin-action-panel {
        background: rgba(31, 30, 30, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }
</style>
@endsection

@section('admin-content')
<div class="flex mx-2 justify-center gap-10">
    <!-- Left Container - Order List (30%) -->
    <div class="w-[30%] h-[750px]">
        <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
            <!-- Title Section -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    ORDERS
                </h2>
                <div class="relative">
                    <select id="statusFilter" name="status" class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-1 focus:ring-[#047705] focus:border-[#047705]">
                        <option value="all" {{ request()->query('status', 'all') === 'all' ? 'selected' : '' }}>All Orders</option>
                        <option value="pending" {{ request()->query('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request()->query('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ request()->query('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="readyforpickup" {{ request()->query('status') === 'readyforpickup' ? 'selected' : '' }}>Ready for Pickup</option>
                        <option value="completed" {{ request()->query('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request()->query('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <hr class="border-[.5px] border-white mb-6 -mx-6">
            
            <!-- Order List -->
            <div class="flex-1 overflow-y-auto pr-2">
                @forelse($orders as $order)
                <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30 order-item cursor-pointer mb-4" 
                     data-order-id="{{ $order->order_id }}"
                     data-status="{{ $order->status }}">
                    <div class="flex items-start">
                        <!-- Order Image -->
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                            @php
                                $firstItem = $order->orderItems->first();
                                $uniform = $firstItem?->uniform;
                            @endphp

                            @if($uniform && $uniform->image_url)
                                <img src="{{ asset($uniform->image_url) }}" alt="{{ $uniform->name }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif


                        </div>
                        
                        <!-- Order Details -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-white font-medium">
                                        {{ $order->orderItems->first() ? $order->orderItems->first()->uniform->name : 'No Items' }}
                                        @if($order->orderItems->count() > 1)
                                            + {{ $order->orderItems->count() - 1 }} more
                                        @endif

                                    </h3>
                                    <p class="text-sm text-gray-400">Order #{{ $order->order_number }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($order->status == 'pending') bg-yellow-500/20 text-yellow-400
                                    @elseif($order->status == 'paid') bg-blue-500/20 text-blue-400
                                    @elseif($order->status == 'processing') bg-purple-500/20 text-purple-400
                                    @elseif($order->status == 'readyforpickup') bg-green-500/20 text-green-400
                                    @elseif($order->status == 'completed') bg-gray-500/20 text-gray-300
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            
                            <div class="mt-2 flex justify-between items-end">
                                <div>
                                    <p class="text-sm text-white">₱{{ number_format($order->total_price, 2) }}</p>
                                    <p class="text-xs text-gray-400">
                                        Ordered:
                                        {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y - h:i A') : 'Date unavailable' }}
                                    </p>

                                </div>
                                <button class="text-sm text-[#ffffff] hover:underline view-details-btn" 
                                        data-order-id="{{ $order->order_id }}"
                                        onclick="loadOrderDetails(event, {{ $order->order_id }})">
                                    Manage Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-400 mt-2">No orders found</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Right Container - Order Management (70%) -->
    <div class="w-[70%] h-[750px]">
        <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
            <!-- Title Section -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    ORDER MANAGEMENT
                </h2>
                <div class="flex space-x-2">
a
                    <button id="cancelOrderBtn" class="px-4 py-2 rounded-lg bg-[#1F1E1E]/80 border border-white/20 text-white hover:bg-[#EF4444]/50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Cancel Order
                    </button>
                </div>
            </div>
            <hr class="border-[.5px] border-white mb-6 -mx-6">
            
            <!-- Order Details Section -->
            <div id="orderDetails" class="hidden flex-1 overflow-y-auto">
                <!-- Order Summary -->
                <div class="bg-[#1F1E1E]/60 rounded-xl p-4 mb-6 border border-white/10">
                    <div class="flex items-start">
                        <!-- Order Image -->
                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                            <img id="trackingOrderImage" src="" alt="Order Image" class="w-full h-full object-contain">
                        </div>
                        
                        <!-- Order Details -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 id="trackingOrderTitle" class="text-white font-medium text-lg"></h3>
                                    <p id="trackingOrderNumber" class="text-sm text-gray-400"></p>
                                    <p id="trackingCustomerInfo" class="text-sm text-gray-400 mt-1"></p>
                                </div>
                                <span id="trackingOrderStatus" class="text-xs px-3 py-1 rounded-full"></span>
                            </div>
                            
                            <div class="mt-2">
                                <p id="trackingOrderPrice" class="text-sm text-white"></p>
                                <p id="trackingOrderDate" class="text-xs text-gray-400"></p>
                                <p id="trackingOrderCompletedDate" class="text-xs text-gray-400 hidden"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Tracking with Admin Controls -->
                <div class="bg-[#1F1E1E]/60 rounded-xl p-6 mb-6 border border-white/10">
                    <h3 class="text-white font-medium mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ORDER STATUS & CONTROLS
                    </h3>
                    
                    <!-- Tracking Steps - Vertical with Admin Actions -->
                    <div class="space-y-8">
                        <!-- Step 1: Payment Verification -->
                        <div class="admin-step-container" data-status="paid">
                            <div class="admin-step-icon bg-white border-4 border-gray-600 relative z-10">
                                <svg class="admin-step-check hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="admin-step-current hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg class="admin-step-icon-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="admin-step-content">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-white font-medium">Payment Verification</h4>
                                        <p class="text-gray-400 text-sm">Verify the payment has been received</p>
                                        <p id="paidDate" class="text-gray-500 text-xs mt-1"></p>
                                    </div>
                                    <div id="paidActions" class="flex space-x-2">
                                        <!-- Buttons will be added dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 2: Order Processing -->
                        <div class="admin-step-container" data-status="processing">
                            <div class="admin-step-icon bg-white border-4 border-gray-600 relative z-10">
                                <svg class="admin-step-check hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="admin-step-current hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg class="admin-step-icon-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="admin-step-content">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-white font-medium">Order Processing</h4>
                                        <p class="text-gray-400 text-sm">Prepare the items for shipping</p>
                                        <p id="processingDate" class="text-gray-500 text-xs mt-1"></p>
                                    </div>
                                    <div id="processingActions" class="flex space-x-2">
                                        <!-- Buttons will be added dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 3: Shipping -->
                        <div class="admin-step-container" data-status="shipped">
                            <div class="admin-step-icon bg-white border-4 border-gray-600 relative z-10">
                                <svg class="admin-step-check hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="admin-step-current hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg class="admin-step-icon-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div class="admin-step-content">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-white font-medium">Ready for Pickup</h4>
                                        <p class="text-gray-400 text-sm">Pick up your order at the Coop Office</p>
                                        <p id="shippedDate" class="text-gray-500 text-xs mt-1"></p>
                                    </div>
                                    <div id="shippedActions" class="flex space-x-2">
                                        <!-- Buttons will be added dynamically -->
                                    </div>
                                </div>
                                <div id="shippingInfo" class="mt-2 hidden">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-400 text-sm mb-1">Tracking Number</label>
                                            <input type="text" id="trackingNumber" class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-2 w-full">
                                        </div>
                                        <div>
                                            <label class="block text-gray-400 text-sm mb-1">Carrier</label>
                                            <select id="carrier" class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-2 w-full">
                                                <option>Select Carrier</option>
                                                <option>LBC</option>
                                                <option>J&T Express</option>
                                                <option>Ninja Van</option>
                                                <option>Flash Express</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 4: Delivery/Completion -->
                        <div class="admin-step-container" data-status="completed">
                            <div class="admin-step-icon bg-white border-4 border-gray-600 relative z-10">
                                <svg class="admin-step-check hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="admin-step-current hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg class="admin-step-icon-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="admin-step-content">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-white font-medium">Completetion</h4>
                                        <p class="text-gray-400 text-sm">Confirm order completion</p>
                                        <p id="completedDate" class="text-gray-500 text-xs mt-1"></p>
                                    </div>
                                    <div id="completedActions" class="flex space-x-2">
                                        <!-- Buttons will be added dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer & Order Information -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <!-- Customer Information -->
                    <div class="bg-[#1F1E1E]/60 rounded-xl p-6 border border-white/10">
                        <h3 class="text-white font-medium mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            CUSTOMER INFORMATION
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-gray-400 text-sm">Name:</p>
                                <p id="customerName" class="text-white">-</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Email:</p>
                                <p id="customerEmail" class="text-white">-</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Phone:</p>
                                <p id="customerPhone" class="text-white">-</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Student ID:</p>
                                <p id="studentId" class="text-white">-</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Details -->
                    <div class="bg-[#1F1E1E]/60 rounded-xl p-6 border border-white/10">
                        <h3 class="text-white font-medium mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            ORDER DETAILS
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-gray-400 text-sm">Payment Method:</p>
                                <p id="paymentMethod" class="text-white">-</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Shipping Method:</p>
                                <p id="shippingMethod" class="text-white">-</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Order Notes:</p>
                                <p id="orderNotes" class="text-white">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="bg-[#1F1E1E]/60 rounded-xl p-6 border border-white/10 mb-6">
                    <h3 class="text-white font-medium mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        ORDER ITEMS
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Item</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Size</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Quantity</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsTable" class="divide-y divide-gray-700">
                                <!-- Items will be populated here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-400">Total:</td>
                                    <td id="orderTotal" class="px-4 py-3 text-left text-sm font-medium text-white">₱0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Empty State for Order Management -->
            <div id="emptyState" class="flex-1 flex flex-col items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-medium text-white mb-2">No Order Selected</h3>
                <p class="text-gray-400 mb-6 max-w-md">Select an order from the list to view details and manage its status.</p>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#1F1E1E] rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-white" id="confirmModalTitle">Confirm Action</h3>
            <button id="closeConfirmModal" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="text-gray-400 mb-6" id="confirmModalMessage">Are you sure you want to perform this action?</p>
        <div class="flex justify-end space-x-3">
            <button type="button" id="cancelConfirm" class="px-4 py-2 rounded-lg bg-[#1F1E1E]/80 border border-white/20 text-white hover:bg-gray-600/50 transition">
                Cancel
            </button>
            <button type="button" id="proceedConfirm" class="px-4 py-2 rounded-lg bg-[#EF4444]/80 text-white hover:bg-[#EF4444] transition">
                Confirm
            </button>
        </div>
    </div>
</div>
<script>
let currentOrderId = null;

const statusProgression = {
    pending: {
        next: 'paid',
        action: 'Mark as Paid',
        target: 'paidActions'
    },
    paid: {
        next: 'processing',
        action: 'Start Processing',
        target: 'processingActions'
    },
    processing: {
        next: 'readyforpickup',
        action: 'Ready for Pickup',
        target: 'shippedActions'
    },
    readyforpickup: {
        next: 'completed',
        action: 'Mark as Completed',
        target: 'completedActions'
    }
};

document.addEventListener('DOMContentLoaded', function() {
    
    // Status filter - redirects with status parameter
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            window.location.href = `/admin/orders?status=${this.value}`;
        });
    }

    // Handle order item clicks (for showing details)
    document.querySelectorAll('.order-item, .view-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const orderId = this.getAttribute('data-order-id');
            if (orderId) {
                loadOrderDetails(e, orderId); // Load in-panel, don't redirect
            }
        });
    });

    // Event delegation for all action buttons
    document.addEventListener('click', async function(e) {
        const orderId = e.target.closest('[data-order-id]')?.getAttribute('data-order-id') || 
                        document.querySelector('#orderDetails')?.getAttribute('data-order-id');

        if (!orderId) return;

        if (e.target.classList.contains('mark-paid-btn')) {
            await updateOrderStatus(orderId, 'paid');
        } 
        else if (e.target.classList.contains('mark-processing-btn')) {
            await updateOrderStatus(orderId, 'processing');
        } 
        else if (e.target.classList.contains('mark-ready-btn')) {
            await updateOrderStatus(orderId, 'readyforpickup');
        } 
        else if (e.target.classList.contains('mark-completed-btn')) {
            await updateOrderStatus(orderId, 'completed');
        } 
        else if (e.target.id === 'cancelOrderBtn') {
            await cancelOrder(orderId);
        }
    });

    // If on order details page, load the details
    if (window.location.pathname.match(/\/admin\/orders\/\d+$/)) {
        const orderId = window.location.pathname.split('/').pop();
        loadOrderDetails({ preventDefault: () => {} }, orderId);
    }
});

async function loadOrderDetails(event, orderId) {
    event.preventDefault();
    event.stopPropagation();
    
    try {
        // Show loading state (you might want to add a spinner)
        document.getElementById('orderDetails').classList.add('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        
        // Fetch order details from your Laravel endpoint
        const response = await fetch(`/admin/orders/${orderId}`);
        if (!response.ok) {
            throw new Error('Failed to fetch order details');
        }
        
        const order = await response.json();
        
        // Populate the order details in the right container
        populateOrderDetails(order);
        updateStepStatus(order.latest_status.toLowerCase()); // Make sure status is lowercase to match your config
        updateActionButtons(order.latest_status.toLowerCase());
        
        // Show the details container
        document.getElementById('orderDetails').classList.remove('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        
    } catch (error) {
        console.error('Error loading order details:', error);
        alert('Failed to load order details');
        // Show empty state if there's an error
        document.getElementById('orderDetails').classList.add('hidden');
        document.getElementById('emptyState').classList.remove('hidden');
    }
}

function populateOrderDetails(order) {
    // Set the current order ID
    currentOrderId = order.order_id;
    document.getElementById('orderDetails').setAttribute('data-order-id', order.order_id);
    
    // Populate basic order info
    const firstItem = order.order_items[0]?.uniform;
    const orderImage = document.getElementById('trackingOrderImage');
    if (firstItem?.image_url) {
        orderImage.src = firstItem.image_url;
        orderImage.alt = firstItem.name;
    } else {
        orderImage.src = '';
        orderImage.alt = 'No image available';
    }
    
    document.getElementById('trackingOrderTitle').textContent = firstItem?.name || 'No Items';
    if (order.order_items.length > 1) {
        document.getElementById('trackingOrderTitle').textContent += ` + ${order.order_items.length - 1} more`;
    }
    
    document.getElementById('trackingOrderNumber').textContent = `Order #${order.order_id || order.id}`;
    document.getElementById('trackingOrderPrice').textContent = `₱${parseFloat(order.total_price).toFixed(2)}`;
    document.getElementById('trackingOrderDate').textContent = `Ordered: ${new Date(order.order_date).toLocaleString()}`;
    
    // Set status badge
    const statusBadge = document.getElementById('trackingOrderStatus');
    statusBadge.textContent = order.latest_status 
        ? order.latest_status === 'ReadyForPickup' 
            ? 'Ready for Pickup' 
            : order.latest_status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())
        : 'Unknown';
    
    statusBadge.className = 'text-xs px-3 py-1 rounded-full ' + 
        (order.latest_status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' :
         order.latest_status === 'paid' ? 'bg-blue-500/20 text-blue-400' :
         order.latest_status === 'processing' ? 'bg-purple-500/20 text-purple-400' :
         order.latest_status === 'readyforickup' ? 'bg-green-500/20 text-green-400' :
         order.latest_status === 'completed' ? 'bg-gray-500/20 text-gray-300' :
         'bg-red-500/20 text-red-300');
    
    // Populate customer info
    document.getElementById('customerName').textContent = order.student?.name || 'N/A';
    document.getElementById('customerEmail').textContent = order.student?.email || 'N/A';
    document.getElementById('customerPhone').textContent = order.student?.phone || 'N/A';
    document.getElementById('studentId').textContent = order.student_id || 'N/A';
    
    // Populate order details
    document.getElementById('paymentMethod').textContent = order.payment_method || 'Cash on Delivery';
    document.getElementById('shippingMethod').textContent = order.shipping_method || 'Pickup';
    document.getElementById('orderNotes').textContent = order.notes || 'No notes';
    
    // Populate order items table
    const itemsTable = document.getElementById('orderItemsTable');
    itemsTable.innerHTML = ''; // Clear existing items
    
    order.order_items.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg overflow-hidden">
                        ${item.uniform?.image_url ? 
                          `<img src="${item.uniform.image_url}" alt="${item.uniform.name}" class="h-full w-full object-contain">` :
                          `<div class="h-full w-full bg-gray-300 flex items-center justify-center">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                              </svg>
                          </div>`}
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-white">${item.uniform?.name || 'Unknown Item'}</div>
                        <div class="text-sm text-gray-400">${item.uniform?.uniform_id || ''}</div>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-white">${item.size || 'N/A'}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-white">₱${parseFloat(item.uniform?.price || 0).toFixed(2)}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-white">${item.quantity || 0}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-white">₱${parseFloat(item.subtotal_price || 0).toFixed(2)}</td>
        `;
        itemsTable.appendChild(row);
    });
    
    // Update total
    document.getElementById('orderTotal').textContent = `₱${parseFloat(order.total_price).toFixed(2)}`;
    
    // Update order tracking timeline
    updateOrderTimeline(order);
}

function updateOrderTimeline(order) {
    const statusOrder = ['paid', 'processing', 'readyforpickup', 'completed'];
    const currentStatusIndex = statusOrder.indexOf(order.status);
    
    document.querySelectorAll('.admin-step-container').forEach(container => {
        const status = container.getAttribute('data-status');
        const statusIndex = statusOrder.indexOf(status);
        const icon = container.querySelector('.admin-step-icon');
        
        // Reset all icons
        icon.querySelector('.admin-step-check')?.classList.add('hidden');
        icon.querySelector('.admin-step-current')?.classList.add('hidden');
        icon.querySelector('.admin-step-icon-default')?.classList.remove('hidden');
        
        // Update based on status
        if (statusIndex < currentStatusIndex) {
            // Completed step
            icon.querySelector('.admin-step-check')?.classList.remove('hidden');
        } else if (statusIndex === currentStatusIndex) {
            // Current step
            icon.querySelector('.admin-step-current')?.classList.remove('hidden');
        }
        
        // Update date display if available
        const dateElement = document.getElementById(`${status}Date`);
        if (dateElement) {
            dateElement.textContent = order.processed_order?.updated_at ? 
                `${statusIndex < currentStatusIndex ? 'Completed' : 'Updated'}: ${new Date(order.processed_order.updated_at).toLocaleString()}` : 
                '';
        }
    });
    
    updateActionButtons(order.latest_status);
}

function updateActionButtons(currentStatus) {
    // Hide all action buttons first
    document.querySelectorAll('[id$="Actions"]').forEach(actionsDiv => {
        actionsDiv.innerHTML = '';
    });

    if (!currentStatus || typeof currentStatus !== 'string') {
        console.error("Invalid or missing currentStatus:", currentStatus);
        return; // Exit early to prevent further errors
    }

    const statusConfig = statusProgression[currentStatus.toLowerCase()];
    if (statusConfig) {
        const actionsDiv = document.getElementById(statusConfig.target);
        if (actionsDiv) {
            actionsDiv.innerHTML = `
                <button onclick="updateOrderStatus(${currentOrderId}, '${statusConfig.next}')" 
                        class="status-action-btn px-3 py-1 rounded-lg bg-[#047705] hover:bg-[#036004] text-white text-sm transition-colors duration-300">
                    ${statusConfig.action}
                </button>
            `;
        }
    }
}

async function updateOrderStatus(orderId, newStatus) {
    if (!confirm(`Are you sure you want to mark this order as ${newStatus.replace(/_/g, ' ')}?`)) {
        return;
    }

    try {
        const response = await fetch(`/admin/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        });

        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || `HTTP error! status: ${response.status}`);
        }
        
        if (data.success) {
            await loadOrderDetails({ preventDefault: () => {}, stopPropagation: () => {} }, orderId);
        } else {
            alert('Failed to update status: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update order status: ' + error.message);
    }
}

function updateStepStatus(currentStatus) {
    document.querySelectorAll('.admin-step-container').forEach(step => {
        const status = step.getAttribute('data-status');
        const check = step.querySelector('.admin-step-check');
        const current = step.querySelector('.admin-step-current');
        const def = step.querySelector('.admin-step-icon-default');
        const iconContainer = step.querySelector('.admin-step-icon');

        // Reset all icons
        check.classList.add('hidden');
        current.classList.add('hidden');
        def.classList.remove('hidden');
        iconContainer.classList.remove('border-[#047705]', 'bg-[#047705]/10');

        if (status === currentStatus) {
            // Current step - show current indicator
            current.classList.remove('hidden');
            
            def.classList.add('hidden');
            // Highlight current step container
            iconContainer.classList.add('border-[#047705]', 'bg-[#047705]/10');
        } else if (isStepBefore(status, currentStatus)) {
            // Completed step - show green checkmark
            check.classList.remove('hidden');
            def.classList.add('hidden');
            // Change checkmark color to green
            check.classList.add('text-[#047705]');
            // Highlight completed step container
            iconContainer.classList.add('border-[#047705]', 'bg-[#047705]/10');
        } else {
            // Future step - show default
            def.classList.remove('hidden');
            // Reset colors
            check.classList.remove('text-[#047705]');
        }
    });
}

function isStepBefore(stepStatus, currentStatus) {
    const order = ["paid", "processing", "shipped", "completed"];
    return order.indexOf(stepStatus) < order.indexOf(currentStatus);
}

document.getElementById('paidDate').textContent = `Verified on ${new Date().toLocaleDateString()}`;

async function cancelOrder(orderId) {
    try {
        const response = await fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to cancel order');
        }

        const data = await response.json();
        console.log('Order canceled successfully:', data);
        // Optionally, refresh the page or update the UI
        window.location.reload();
    } catch (error) {
        console.error('Error canceling order:', error.message);
        alert('Failed to cancel order: ' + error.message);
    }
}

</script>
@endsection