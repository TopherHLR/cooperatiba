@extends('accountslayout')

@section('title', 'Orders')

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
    /* Order status colors */
    .status-pending {
        color: #EDD100;
        background-color: rgba(237, 209, 0, 0.1);
    }
    
    .status-processing {
        color: #047705;
        background-color: rgba(4, 119, 5, 0.1);
    }
    
    .status-completed {
        color: #3B82F6;
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .status-cancelled {
        color: #EF4444;
        background-color: rgba(239, 68, 68, 0.1);
    }
        /* Tracking Steps */
        .step-container {
        position: relative;
        display: flex;
        align-items: flex-start;
    }
    
    .step-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 16px;
        position: relative;
        z-index: 2;
    }
    
    .step-icon svg {
        width: 18px;
        height: 18px;
    }
    
    .step-content {
        flex: 1;
        padding-top: 4px;
    }
    
    /* Active step styling */
    .step-container.active .step-icon {
        border-color: #047705;
        background-color: #047705;
    }
    
    .step-container.active .step-current {
        display: block;
        color: white;
    }
    
    /* Completed step styling */
    .step-container.completed .step-icon {
        border-color: #047705;
    }
    
    .step-container.completed .step-check {
        display: block;
    }
    
    .step-container.completed .step-current {
        display: none;
    }
</style>
@endsection

@section('account-content')
<div class="content-section min-h-screen">
    <div class="content-overlay min-h-screen">
        <div class="flex mx-2 justify-center gap-10"> <!-- Centered containers -->
            <!-- Left Container - Order History (60%) -->
            <div class="w-[30%] mr-6">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            ORDER HISTORY
                        </h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Order History List -->
                    <div class="space-y-4 h-[580px] overflow-y-auto pr-2">
                        <!-- Order Item 1 -->
                        <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30">
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
                                        <span class="text-xs px-2 py-1 rounded-full status-pending">Pending</span>
                                    </div>
                                    
                                    <div class="mt-2 flex justify-between items-end">
                                        <div>
                                            <p class="text-sm text-white">₱250.00 × 1</p>
                                            <p class="text-xs text-gray-400">Ordered: May 15, 2023 - 10:30 AM</p>
                                        </div>
                                        <!-- In each order item, modify the "View Details" button like this: -->
                                        <button 
                                            class="text-md text-[#047705] hover:underline view-details-btn" 
                                            data-order-number="COOP-2023-001"
                                            onclick="selectOrder('COOP-2023-001')"> <!-- Change this for each order -->
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- Order Item 2 -->
                            <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30">
                                <div class="flex items-start">
                                    <!-- Order Image -->
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                        <img src="/images/clothes/school-uniform.png" alt="School Uniform" class="w-full h-full object-contain">
                                    </div>
                                    
                                    <!-- Order Details -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-white font-medium">School Uniform (Size L)</h3>
                                                <p class="text-sm text-gray-400">Order #COOP-2023-002</p>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-full status-processing">Processing</span>
                                        </div>
                                        
                                        <div class="mt-2 flex justify-between items-end">
                                            <div>
                                                <p class="text-sm text-white">₱350.00 × 2</p>
                                                <p class="text-xs text-gray-400">Ordered: May 10, 2023 - 2:15 PM</p>
                                            </div>
                                            <button 
                                                class="text-md text-[#047705] hover:underline view-details-btn" 
                                                data-order-number="COOP-2023-002"
                                                onclick="selectOrder('COOP-2023-002')"> <!-- Change this for each order -->
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Order Item 3 -->
                            <div class="bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-[#047705]/30">
                                <div class="flex items-start">
                                    <!-- Order Image -->
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                        <img src="/images/clothes/lab-gown.png" alt="Lab Gown" class="w-full h-full object-contain">
                                    </div>
                                    
                                    <!-- Order Details -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-white font-medium">Lab Gown (Size XL)</h3>
                                                <p class="text-sm text-gray-400">Order #COOP-2023-003</p>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-full status-completed">Completed</span>
                                        </div>
                                        
                                        <div class="mt-2 flex justify-between items-end">
                                            <div>
                                                <p class="text-sm text-white">₱400.00 × 1</p>
                                                <p class="text-xs text-gray-400">Ordered: May 5, 2023 - 9:45 AM</p>
                                                <p class="text-xs text-gray-400">Completed: May 8, 2023 - 3:20 PM</p>
                                            </div>
                                            <button 
                                                class="text-md text-[#047705] hover:underline view-details-btn" 
                                                data-order-number="COOP-2023-003"
                                                onclick="selectOrder('COOP-2023-003')"> <!-- Change this for each order -->
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Container - Track Order (70%) -->
            <div class="w-[70%]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            TRACK YOUR ORDER
                        </h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Order Details Section (shown when order is selected) -->
                    <div id="orderDetails" class="hidden">
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
                        
                    <!-- Horizontal Tracking Progress -->
                        <div class="bg-[#1F1E1E]/60 rounded-xl p-6 mb-6 border border-white/10">
                            <h3 class="text-white font-medium mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                ORDER STATUS
                            </h3>
                            
                            <!-- Tracking Steps - Horizontal -->
                            <div class="relative">
                                <!-- Progress Line -->
                                <div class="absolute left-0 right-0 top-4 h-0.5 bg-gray-600 mx-16">
                                    <div id="progressFill" class="bg-[#047705] h-0.5 w-0 transition-all duration-500"></div>
                                </div>
                                
                                <!-- Steps Container -->
                                <div class="flex justify-between px-8">
                                    <!-- Step 1: Paid -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="paid">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center ">
                                            <h4 class="text-white font-medium text-sm">Payment Received</h4>
                                            <p class="text-gray-400 text-xs">Your payment has been confirmed</p>
                                            <p id="paidDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 2: Processing -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="processing">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Processing Order</h4>
                                            <p class="text-gray-400 text-xs">Preparing your items</p>
                                            <p id="processingDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 3: In Transit -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="transit">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">In Transit</h4>
                                            <p class="text-gray-400 text-xs">Your order is on its way</p>
                                            <p id="transitDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 4: Ready for Pickup -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="ready">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Ready for Pickup</h4>
                                            <p class="text-gray-400 text-xs">Ready at the coop store</p>
                                            <p id="readyDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pickup Information -->
                        <div class="bg-[#1F1E1E]/60 rounded-xl p-6 border border-white/10">
                            <h3 class="text-white font-medium mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                PICKUP INFORMATION
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400 text-sm">Pickup Location:</p>
                                    <p class="text-white">Cooperative Store, Main Campus</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Estimated Pickup Date:</p>
                                    <p id="estimatedPickupDate" class="text-white">-</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Contact Number:</p>
                                    <p class="text-white">(02) 8888-9999</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Opening Hours:</p>
                                    <p class="text-white">8:00 AM - 5:00 PM (Mon-Fri)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Empty State for Track Order -->
                    <div id="emptyState" class="flex flex-col items-center justify-center h-[580px] text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-xl font-medium text-white mb-2">No Order Selected</h3>
                        <p class="text-gray-400 mb-6 max-w-md">Select an order from your history to view tracking information and current status.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        // Sample data for orders
        const orders = {
        'COOP-2023-001': {
            title: 'PE Uniform (Size M)',
            image: '/images/clothes/pe.png',
            price: '₱250.00 × 1',
            date: 'Ordered: May 15, 2023 - 10:30 AM',
            status: 'processing',
            statusText: 'Processing',
            statusClass: 'status-processing',
            steps: {
                paid: 'May 15, 2023 - 10:35 AM',
                processing: 'May 15, 2023 - 11:45 AM',
                transit: '',
                ready: ''
            },
            estimatedPickup: 'May 18, 2023'
        },
        'COOP-2023-002': {
            title: 'School Uniform (Size L)',
            image: '/images/clothes/school-uniform.png',
            price: '₱350.00 × 2',
            date: 'Ordered: May 10, 2023 - 2:15 PM',
            status: 'transit',
            statusText: 'In Transit',
            statusClass: 'status-processing',
            steps: {
                paid: 'May 10, 2023 - 2:20 PM',
                processing: 'May 11, 2023 - 9:15 AM',
                transit: 'May 12, 2023 - 2:30 PM',
                ready: ''
            },
            estimatedPickup: 'May 15, 2023'
        },
        'COOP-2023-003': {
            title: 'Lab Gown (Size XL)',
            image: '/images/clothes/lab-gown.png',
            price: '₱400.00 × 1',
            date: 'Ordered: May 5, 2023 - 9:45 AM',
            completedDate: 'Completed: May 8, 2023 - 3:20 PM',
            status: 'ready',
            statusText: 'Completed',
            statusClass: 'status-completed',
            steps: {
                paid: 'May 5, 2023 - 9:50 AM',
                processing: 'May 5, 2023 - 3:15 PM',
                transit: 'May 6, 2023 - 10:30 AM',
                ready: 'May 8, 2023 - 1:45 PM'
            },
            estimatedPickup: 'May 8, 2023'
        },
    };

    // Function to handle order selection
    function selectOrder(orderNumber) {
        const order = orders[orderNumber];
        if (!order) return;
        
        // Hide empty state and show order details
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('orderDetails').classList.remove('hidden');
        
        // Update order information
        document.getElementById('trackingOrderImage').src = order.image;
        document.getElementById('trackingOrderTitle').textContent = order.title;
        document.getElementById('trackingOrderNumber').textContent = `Order #${orderNumber}`;
        document.getElementById('trackingOrderPrice').textContent = order.price;
        document.getElementById('trackingOrderDate').textContent = order.date;
        document.getElementById('trackingOrderStatus').textContent = order.statusText;
        document.getElementById('trackingOrderStatus').className = `text-xs px-3 py-1 rounded-full ${order.statusClass}`;
        document.getElementById('estimatedPickupDate').textContent = order.estimatedPickup;
        
        // Show/hide completed date if exists
        const completedDateEl = document.getElementById('trackingOrderCompletedDate');
        if (order.completedDate) {
            completedDateEl.textContent = order.completedDate;
            completedDateEl.classList.remove('hidden');
        } else {
            completedDateEl.classList.add('hidden');
        }
        
        // Update tracking steps
        updateTrackingSteps(order.status, order.steps);
    }
    
    // Function to update tracking steps visualization
    function updateTrackingSteps(currentStatus, steps) {
        const statusOrder = ['paid', 'processing', 'transit', 'ready'];
        let currentStepIndex = statusOrder.indexOf(currentStatus);
        
        // Reset all steps
        document.querySelectorAll('.step-container').forEach(container => {
            container.classList.remove('completed', 'active');
            const status = container.getAttribute('data-status');
            
            // Hide all icons first
            container.querySelector('.step-check').classList.add('hidden');
            container.querySelector('.step-current').classList.add('hidden');
            
            // Show date if exists
            const dateElement = document.getElementById(`${status}Date`);
            if (steps[status]) {
                dateElement.textContent = steps[status];
                dateElement.classList.remove('text-gray-500');
                dateElement.classList.add('text-gray-400');
            } else {
                dateElement.textContent = '-';
                dateElement.classList.remove('text-gray-400');
                dateElement.classList.add('text-gray-500');
            }
        });
        
        // Mark completed steps
        for (let i = 0; i < currentStepIndex; i++) {
            const status = statusOrder[i];
            const container = document.querySelector(`.step-container[data-status="${status}"]`);
            container.classList.add('completed');
            
            // Show check icon
            container.querySelector('.step-check').classList.remove('hidden');
        }
        
        // Mark current step
        if (currentStepIndex >= 0) {
            const currentStatus = statusOrder[currentStepIndex];
            const container = document.querySelector(`.step-container[data-status="${currentStatus}"]`);
            container.classList.add('active');
            
            // Show current icon
            container.querySelector('.step-current').classList.remove('hidden');
        }
        
        // Update progress line
        const progressFill = document.getElementById('progressFill');
        if (currentStepIndex >= 0) {
            const percentage = (currentStepIndex / (statusOrder.length - 1)) * 100;
            progressFill.style.height = `${percentage}%`;
        } else {
            progressFill.style.height = '0%';
        }
    }
    
    // Add click handlers to view details buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Select all view details buttons
        const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
        
        // Add click event to each button
        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent event bubbling
                const orderNumber = this.getAttribute('data-order-number');
                selectOrder(orderNumber);
            });
        });

        // Optional: Add click handler to the entire order item if you want
        document.querySelectorAll('.order-item').forEach(item => {
            item.addEventListener('click', function() {
                const button = this.querySelector('.view-details-btn');
                const orderNumber = button.getAttribute('data-order-number');
                selectOrder(orderNumber);
            });
        });
    });
</script>
@endsection