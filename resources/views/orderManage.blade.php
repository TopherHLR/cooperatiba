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
<div class="content-section min-h-full">
    <div class="content-overlay min-h-full">
        <div class="flex mx-2 justify-center gap-10">
            <!-- Left Container - Order List (30%) -->
            <div class="w-[30%] mr-6  h-[750px]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
                    <!-- Title Section -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            ORDERS
                        </h2>
                        <div class="relative">
                            <select class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-1 focus:ring-[#047705] focus:border-[#047705]">
                                <option selected>Filter Orders</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Order List -->
                    <div class="flex-1 overflow-y-auto pr-2">
                        <!-- Order Item 1 -->
                        <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30 order-item cursor-pointer mb-4">
                            <div class="flex items-start">
                                <!-- Order Image -->
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                    <img src="/images/clothes/pe.png" alt="PE Uniform" class="w-full h-full object-contain">
                                </div>
                                
                                <!-- Order Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-medium">PE Uniform (Size M)</h3>
                                            <p class="text-sm text-gray-400">Order #COOP-2023-001</p>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full admin-status-pending">Pending</span>
                                    </div>
                                    
                                    <div class="mt-2 flex justify-between items-end">
                                        <div>
                                            <p class="text-sm text-white">₱250.00 × 1</p>
                                            <p class="text-xs text-gray-400">Ordered: May 15, 2023 - 10:30 AM</p>
                                        </div>
                                        <button class="text-sm text-[#ffffff] hover:underline view-details-btn" 
                                                data-order-number="COOP-2023-001">
                                            Manage Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Item 2 -->
                        <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30 order-item cursor-pointer mb-4">
                            <div class="flex items-start">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                    <img src="/images/clothes/school-uniform.png" alt="School Uniform" class="w-full h-full object-contain">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-medium">School Uniform (Size L)</h3>
                                            <p class="text-sm text-gray-400">Order #COOP-2023-002</p>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full admin-status-processing">Processing</span>
                                    </div>
                                    <div class="mt-2 flex justify-between items-end">
                                        <div>
                                            <p class="text-sm text-white">₱350.00 × 2</p>
                                            <p class="text-xs text-gray-400">Ordered: May 10, 2023 - 2:15 PM</p>
                                        </div>
                                        <button class="text-sm text-[#ffffff] hover:underline view-details-btn" 
                                                data-order-number="COOP-2023-002">
                                            Manage Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Item 3 -->
                        <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30 order-item cursor-pointer mb-4">
                            <div class="flex items-start">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                    <img src="/images/clothes/lab-gown.png" alt="Lab Gown" class="w-full h-full object-contain">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-medium">Lab Gown (Size XL)</h3>
                                            <p class="text-sm text-gray-400">Order #COOP-2023-003</p>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full admin-status-completed">Completed</span>
                                    </div>
                                    <div class="mt-2 flex justify-between items-end">
                                        <div>
                                            <p class="text-sm text-white">₱400.00 × 1</p>
                                            <p class="text-xs text-gray-400">Completed: May 8, 2023 - 3:20 PM</p>
                                        </div>
                                        <button class="text-sm text-[#ffffff] hover:underline view-details-btn" 
                                                data-order-number="COOP-2023-003">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Container - Order Management (70%) -->
            <div class="w-[70%]  h-[750px]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
                    <!-- Title Section -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            ORDER MANAGEMENT
                        </h2>
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 rounded-lg bg-[#1F1E1E]/80 border border-white/20 text-white hover:bg-[#047705]/50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Note
                            </button>
                            <button class="px-4 py-2 rounded-lg bg-[#1F1E1E]/80 border border-white/20 text-white hover:bg-[#EF4444]/50 transition">
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
                                                <h4 class="text-white font-medium">Shipping</h4>
                                                <p class="text-gray-400 text-sm">Ship the order to customer</p>
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
                                                    <input type="text" class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-2 w-full">
                                                </div>
                                                <div>
                                                    <label class="block text-gray-400 text-sm mb-1">Carrier</label>
                                                    <select class="bg-[#1F1E1E]/80 border border-white/20 text-white text-sm rounded-lg px-3 py-2 w-full">
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
                                                <h4 class="text-white font-medium">Delivery/Completion</h4>
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
    </div>
</div>

<script>
    const adminOrders = {
        'COOP-2023-001': {
            title: 'PE Uniform (Size M)',
            image: '/images/clothes/pe.png',
            price: '₱250.00 × 1',
            date: 'Ordered: May 15, 2023 - 10:30 AM',
            status: 'pending',
            statusText: 'Pending',
            statusClass: 'admin-status-pending',
            customer: {
                name: 'Juan Dela Cruz',
                email: 'juan.delacruz@example.com',
                phone: '+63 912 345 6789',
                studentId: '2023-00123'
            },
            details: {
                paymentMethod: 'GCash (•••• 7890)',
                shippingMethod: 'School Pickup',
                notes: 'Please include receipt in package'
            },
            steps: {
                paid: '',
                processing: '',
                shipped: '',
                completed: ''
            }
        },
        'COOP-2023-002': {
            title: 'School Uniform (Size L)',
            image: '/images/clothes/school-uniform.png',
            price: '₱350.00 × 2',
            date: 'Ordered: May 10, 2023 - 2:15 PM',
            status: 'processing',
            statusText: 'Processing',
            statusClass: 'admin-status-processing',
            customer: {
                name: 'Maria Santos',
                email: 'maria.santos@example.com',
                phone: '+63 917 890 1234',
                studentId: '2023-00456'
            },
            details: {
                paymentMethod: 'Bank Transfer (BDO)',
                shippingMethod: 'School Pickup',
                notes: 'Urgent - needed for graduation'
            },
            steps: {
                paid: 'May 10, 2023 - 2:20 PM',
                processing: 'May 11, 2023 - 9:15 AM',
                shipped: '',
                completed: ''
            }
        },
        'COOP-2023-003': {
            title: 'Lab Gown (Size XL)',
            image: '/images/clothes/lab-gown.png',
            price: '₱400.00 × 1',
            date: 'Ordered: May 5, 2023 - 9:45 AM',
            completedDate: 'Completed: May 8, 2023 - 3:20 PM',
            status: 'completed',
            statusText: 'Completed',
           
            statusClass: 'admin-status-completed',
            customer: {
                name: 'Pedro Reyes',
                email: 'pedro.reyes@example.com',
                phone: '+63 918 765 4321',
                studentId: '2023-00789'
            },
            details: {
                paymentMethod: 'Cash on Pickup',
                shippingMethod: 'School Pickup',
                notes: 'Please ensure proper packaging'
            },
            steps: {
                paid: 'May 5, 2023 - 10:00 AM',
                processing: 'May 5, 2023 - 1:30 PM',
                shipped: 'May 6, 2023 - 9:00 AM',
                completed: 'May 8, 2023 - 3:20 PM'
            }
        }
    };

    // DOM elements
    const orderItems = document.querySelectorAll('.order-item');
    const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
    const orderDetailsSection = document.getElementById('orderDetails');
    const emptyState = document.getElementById('emptyState');

    // Order detail elements
    const trackingOrderImage = document.getElementById('trackingOrderImage');
    const trackingOrderTitle = document.getElementById('trackingOrderTitle');
    const trackingOrderNumber = document.getElementById('trackingOrderNumber');
    const trackingCustomerInfo = document.getElementById('trackingCustomerInfo');
    const trackingOrderStatus = document.getElementById('trackingOrderStatus');
    const trackingOrderPrice = document.getElementById('trackingOrderPrice');
    const trackingOrderDate = document.getElementById('trackingOrderDate');
    const trackingOrderCompletedDate = document.getElementById('trackingOrderCompletedDate');

    // Customer info elements
    const customerName = document.getElementById('customerName');
    const customerEmail = document.getElementById('customerEmail');
    const customerPhone = document.getElementById('customerPhone');
    const studentId = document.getElementById('studentId');

    // Order detail elements
    const paymentMethod = document.getElementById('paymentMethod');
    const shippingMethod = document.getElementById('shippingMethod');
    const orderNotes = document.getElementById('orderNotes');

    // Step date elements
    const paidDate = document.getElementById('paidDate');
    const processingDate = document.getElementById('processingDate');
    const shippedDate = document.getElementById('shippedDate');
    const completedDate = document.getElementById('completedDate');

    // Action containers
    const paidActions = document.getElementById('paidActions');
    const processingActions = document.getElementById('processingActions');
    const shippedActions = document.getElementById('shippedActions');
    const completedActions = document.getElementById('completedActions');

    // Shipping info
    const shippingInfo = document.getElementById('shippingInfo');

    // Function to load order details
    function loadOrderDetails(orderNumber) {
        const order = adminOrders[orderNumber];
        
        if (!order) return;
        
        // Update order summary
        trackingOrderImage.src = order.image;
        trackingOrderTitle.textContent = order.title;
        trackingOrderNumber.textContent = `Order #${orderNumber}`;
        trackingCustomerInfo.textContent = `Customer: ${order.customer.name}`;
        trackingOrderStatus.textContent = order.statusText;
        trackingOrderStatus.className = `text-xs px-3 py-1 rounded-full ${order.statusClass}`;
        trackingOrderPrice.textContent = order.price;
        trackingOrderDate.textContent = order.date;
        
        if (order.completedDate) {
            trackingOrderCompletedDate.textContent = order.completedDate;
            trackingOrderCompletedDate.classList.remove('hidden');
        } else {
            trackingOrderCompletedDate.classList.add('hidden');
        }
        
        // Update customer info
        customerName.textContent = order.customer.name;
        customerEmail.textContent = order.customer.email;
        customerPhone.textContent = order.customer.phone;
        studentId.textContent = order.customer.studentId;
        
        // Update order details
        paymentMethod.textContent = order.details.paymentMethod;
        shippingMethod.textContent = order.details.shippingMethod;
        orderNotes.textContent = order.details.notes || 'No notes provided';
        
        // Update step dates
        paidDate.textContent = order.steps.paid ? `Verified on ${order.steps.paid}` : 'Pending verification';
        processingDate.textContent = order.steps.processing ? `Started on ${order.steps.processing}` : 'Not yet started';
        shippedDate.textContent = order.steps.shipped ? `Shipped on ${order.steps.shipped}` : 'Not yet shipped';
        completedDate.textContent = order.steps.completed ? `Completed on ${order.steps.completed}` : 'Not yet completed';
        
        // Update step statuses
        updateStepStatuses(orderNumber);
        
        // Show order details and hide empty state
        orderDetailsSection.classList.remove('hidden');
        emptyState.classList.add('hidden');
    }

    // Function to update step statuses
    function updateStepStatuses(orderNumber) {
        const order = adminOrders[orderNumber];
        const steps = document.querySelectorAll('.admin-step-container');
        
        // Reset all steps
        steps.forEach(step => {
            step.classList.remove('completed', 'active');
            const icon = step.querySelector('.admin-step-icon');
            icon.classList.remove('bg-[#047705]', 'border-[#047705]');
            
            // Reset icons
            step.querySelector('.admin-step-check').classList.add('hidden');
            step.querySelector('.admin-step-current').classList.add('hidden');
            step.querySelector('.admin-step-icon-default').classList.remove('hidden');
        });
        
        // Clear all action buttons
        paidActions.innerHTML = '';
        processingActions.innerHTML = '';
        shippedActions.innerHTML = '';
        completedActions.innerHTML = '';
        
        // Hide shipping info by default
        shippingInfo.classList.add('hidden');
        
        // Determine current status and update steps accordingly
        let currentStepReached = false;
        
        steps.forEach(step => {
            const status = step.getAttribute('data-status');
            
            if (order.steps[status]) {
                // Step is completed
                step.classList.add('completed');
                const icon = step.querySelector('.admin-step-icon');
                icon.classList.add('bg-[#047705]', 'border-[#047705]');
                
                step.querySelector('.admin-step-check').classList.remove('hidden');
                step.querySelector('.admin-step-icon-default').classList.add('hidden');
            } else if (!currentStepReached && order.status !== 'cancelled') {
                // This is the current active step
                currentStepReached = true;
                step.classList.add('active');
                const icon = step.querySelector('.admin-step-icon');
                icon.classList.add('bg-[#047705]', 'border-[#047705]');
                
                step.querySelector('.admin-step-current').classList.remove('hidden');
                step.querySelector('.admin-step-icon-default').classList.add('hidden');
                
                // Add appropriate action buttons based on step
                addActionButtons(status, step);
            }
        });
    }

    // Function to add action buttons based on step
    function addActionButtons(step, stepElement) {
        let actionsContainer;
        let buttonText;
        let actionFunction;
        
        switch (step) {
            case 'paid':
                actionsContainer = paidActions;
                buttonText = 'Verify Payment';
                actionFunction = verifyPayment;
                break;
            case 'processing':
                actionsContainer = processingActions;
                buttonText = 'Start Processing';
                actionFunction = startProcessing;
                break;
            case 'shipped':
                actionsContainer = shippedActions;
                buttonText = 'Mark as Shipped';
                actionFunction = markAsShipped;
                break;
            case 'completed':
                actionsContainer = completedActions;
                buttonText = 'Mark as Completed';
                actionFunction = markAsCompleted;
                break;
            default:
                return;
        }
        
        // Create approve button
        const approveBtn = document.createElement('button');
        approveBtn.textContent = buttonText;
        approveBtn.className = 'px-3 py-1 rounded-lg text-sm approve-btn';
        approveBtn.addEventListener('click', actionFunction);
        actionsContainer.appendChild(approveBtn);
        
        // For shipped step, add shipping info toggle
        if (step === 'shipped') {
            const toggleShippingBtn = document.createElement('button');
            toggleShippingBtn.textContent = 'Add Shipping Info';
            toggleShippingBtn.className = 'px-3 py-1 rounded-lg text-sm bg-[#1F1E1E]/80 border border-white/20 text-white hover:bg-[#3B82F6]/50 transition';
            toggleShippingBtn.addEventListener('click', () => {
                shippingInfo.classList.toggle('hidden');
            });
            actionsContainer.appendChild(toggleShippingBtn);
        }
    }

    // Action functions
    function verifyPayment() {
        alert('Payment verified successfully!');
        // In a real app, this would make an API call
    }
    
    function startProcessing() {
        alert('Order processing started!');
        // In a real app, this would make an API call
    }
    
    function markAsShipped() {
        alert('Order marked as shipped!');
        // In a real app, this would make an API call
    }
    
    function markAsCompleted() {
        alert('Order marked as completed!');
        // In a real app, this would make an API call
    }

    // Event listeners
    viewDetailsBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const orderNumber = e.currentTarget.getAttribute('data-order-number');
            loadOrderDetails(orderNumber);
            
            // Update active state in order list
            orderItems.forEach(item => {
                item.classList.remove('border-[#047705]/30', 'bg-[#001C00]/40');
            });
            
            // Find the parent order item and highlight it
            const orderItem = e.currentTarget.closest('.order-item');
            if (orderItem) {
                orderItem.classList.add('border-[#047705]/30', 'bg-[#001C00]/40');
            }
        });
    });

    // Initialize with first order selected (for demo purposes)
    document.addEventListener('DOMContentLoaded', () => {
        // Uncomment to auto-load first order
        // loadOrderDetails('COOP-2023-001');
    });
</script>
@endsection