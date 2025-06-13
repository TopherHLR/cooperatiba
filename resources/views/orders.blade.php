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
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-section min-h-full">
    <div class="content-overlay min-h-full">
        <div class="flex mx-2 justify-center gap-10"> <!-- Centered containers -->
            <!-- Left Container - Order History (30%) -->
            <div class="w-[30%]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/80 to-[#100E0E]/80 border border-gray-600 shadow-lg shadow-black/40 rounded-xl p-6 h-full backdrop-blur-sm">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0 #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            ORDER HISTORY
                        </h2>
                    </div>
                    <hr class="border border-gray-600 mb-6 -mx-6">

                    <!-- Order History List -->
                    <div class="space-y-4 h-[580px] overflow-y-auto pr-2" id="ordersContainer">
                        <!-- Loading State -->
                        <div id="loadingState" class="flex flex-col items-center justify-center h-full text-center">
                            <svg class="animate-spin h-8 w-8 text-white mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-400">Loading orders...</p>
                        </div>
                        <!-- Empty State -->
                        <div id="emptyOrdersState" class="hidden flex flex-col items-center justify-center h-full text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-xl font-medium text-white mb-2">No Orders Found</h3>
                            <p class="text-gray-400">You haven't placed any orders yet.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Container - Track Order (70%) -->
            <div class="w-[70%]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
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
                    <div id="userOrdersContainer" class="hidden">
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
                                        <span id="trackingOrderStatus" class="text-xs px-3 py-1 rounded-full text-white"></span>
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
                                        <div class="step-icon bg-white border-4 border-gray-600 relative ml-[75px] z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <svg class="step-cancel hidden text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Payment Received</h4>
                                            <p class="text-gray-400 text-xs">Your payment has been confirmed</p>
                                            <p id="paidDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 2: Processing -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="processing">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative ml-[48px] z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <svg class="step-cancel hidden text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Processing Order</h4>
                                            <p class="text-gray-400 text-xs">Preparing your items</p>
                                            <p id="processingDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 3: Ready for Pickup -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="readyforpickup">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative ml-[47px]  z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <svg class="step-cancel hidden text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Ready for Pickup</h4>
                                            <p class="text-gray-400 text-xs">Ready at the coop store</p>
                                            <p id="readyforpickupDate" class="text-gray-500 text-xs mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Step 4: Completed -->
                                    <div class="step-container flex flex-col items-center w-1/4" data-status="completed">
                                        <div class="step-icon bg-white border-4 border-gray-600 relative ml-[56px] z-10 mb-2">
                                            <svg class="step-check hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg class="step-current hidden text-[#047705]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <svg class="step-cancel hidden text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="step-content text-center">
                                            <h4 class="text-white font-medium text-sm">Completed</h4>
                                            <p class="text-gray-400 text-xs">Order successfully picked up</p>
                                            <p id="completedDate" class="text-gray-500 text-xs mt-1"></p>
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
                                    <p id="pickupLocation" class="text-white">Cooperative Store, Main Campus</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Estimated Pickup Date:</p>
                                    <p id="estimatedPickupDate" class="text-white">-</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Contact Number:</p>
                                    <p class="text-white">(+63) 968-315-1166</p>
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
document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('ordersContainer');
    const loadingState = document.getElementById('loadingState');
    const emptyOrdersState = document.getElementById('emptyOrdersState');
    const userOrdersContainer = document.getElementById('userOrdersContainer');
    const emptyState = document.getElementById('emptyState');

    async function fetchUserOrders() {
        try {
            loadingState.classList.remove('hidden');
            ordersContainer.innerHTML = '';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/api/orders', { // Changed from '/orders' to '/api/orders'                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'include'
            });

            if (response.redirected && response.url.includes('/login')) {
                window.location.href = '/login';
                return [];
            }

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            loadingState.classList.add('hidden');

            if (!data.success || data.orders.length === 0) {
                emptyOrdersState.classList.remove('hidden');
                return [];
            }

            emptyOrdersState.classList.add('hidden');
            renderOrders(data.orders);
            return data.orders;

        } catch (error) {
            console.error('Error fetching user orders:', error);
            loadingState.classList.add('hidden');
            emptyOrdersState.classList.remove('hidden');
            emptyOrdersState.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-medium text-white mb-2">Error Loading Orders</h3>
                <p class="text-gray-400">${error.message}</p>
            `;
            return [];
        }
    }

    function renderOrders(orders) {
        ordersContainer.innerHTML = '';

        if (orders.length === 0) {
            emptyOrdersState.classList.remove('hidden');
            return;
        }

        orders.forEach(order => {
            const currentStatus = getCurrentStatus(order.status_histories);
            const status = currentStatus.status.toLowerCase();
            const firstItem = order.order_items[0]?.uniform || {};

            // Set display status for "readytopickup" to "Ready for Pickup"
            const displayStatus = status === 'readyforpickup' ? 'Ready for Pickup' : 
                status.charAt(0).toUpperCase() + status.slice(1);

            const orderDiv = document.createElement('div');
            orderDiv.className = 'bg-[#1F1E1E]/60 p-4 rounded-lg cursor-pointer hover:bg-[#2F2E2E]/60 transition border border-white/10 order-item';
            orderDiv.dataset.orderId = order.order_id;

            orderDiv.innerHTML = `
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 mr-4">
                        <img src="${firstItem.image_url || '/images/placeholder.png'}" alt="Order Image" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-medium text-sm">${firstItem.name || 'Order Items'}</h3>
                        <p class="text-gray-400 text-xs">Order #${order.order_id}</p>
                        <p class="text-gray-400 text-xs">Placed: ${formatDate(order.order_date)}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full ${getStatusColor(currentStatus.status)}">
                        ${displayStatus}
                    </span>
                </div>
            `;

            ordersContainer.appendChild(orderDiv);
        });
    }

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusColor(status) {
        const colors = {
            pending: 'bg-yellow-500 text-white',
            paid: 'bg-green-500 text-white',
            processing: 'bg-blue-500 text-blue-900',
            readyforpickup: 'bg-purple-500 text-white',
            completed: 'bg-green-700 text-white',
            cancelled: 'bg-red-500 text-white'
        };
        return colors[status.toLowerCase()] || 'bg-gray-500 text-gray-900';
    }

    function getCurrentStatus(statusHistories) {
        if (!statusHistories || statusHistories.length === 0) {
            return { status: 'pending', updated_at: new Date().toISOString() };
        }
        
        return statusHistories.reduce((latest, history) => {
            return new Date(history.updated_at) > new Date(latest.updated_at) ? history : latest;
        });
    }

    function updateTrackingProgress(order) {
    const currentStatus = getCurrentStatus(order.status_histories);
    const status = currentStatus.status.toLowerCase();
    
    // Update progress bar
    const steps = ['paid', 'processing', 'readyforpickup', 'completed'];
    const currentStepIndex = steps.indexOf(status);
    const progressPercentage = status === 'cancelled' ? 100 : (currentStepIndex >= 0 ? ((currentStepIndex + 1) / steps.length) * 100 : 0);
    const progressFill = document.getElementById('progressFill');
    progressFill.style.width = `${progressPercentage}%`;
    
    // Set progress bar color based on status
    progressFill.classList.remove('bg-[#047705]', 'bg-red-500');
    progressFill.classList.add(status === 'cancelled' ? 'bg-red-500' : 'bg-[#047705]');

    // Update each step
    steps.forEach((step, index) => {
        const stepContainer = document.querySelector(`.step-container[data-status="${step}"]`);
        const checkIcon = stepContainer?.querySelector('.step-check');
        const currentIcon = stepContainer?.querySelector('.step-current');
        const cancelIcon = stepContainer?.querySelector('.step-cancel');
        const iconContainer = stepContainer?.querySelector('.step-icon');
        const dateElement = document.getElementById(`${step}Date`);

        if (checkIcon && currentIcon && cancelIcon && iconContainer) {
            // Reset all icons and styles
            checkIcon.classList.add('hidden');
            currentIcon.classList.add('hidden');
            cancelIcon.classList.add('hidden');
            iconContainer.classList.remove('border-[#047705]', 'bg-[#047705]/10', 'border-red-500', 'bg-red-500/10');
            checkIcon.classList.remove('text-[#047705]', 'text-red-500');
            currentIcon.classList.remove('text-[#047705]', 'text-red-500');
            cancelIcon.classList.remove('text-red-500');

            if (status === 'cancelled') {
                // For cancelled orders, show red "X" icons for all steps
                cancelIcon.classList.remove('hidden');
                cancelIcon.classList.add('text-red-500');
                iconContainer.classList.add('border-red-500', 'bg-red-500/10');
            } else if (index === currentStepIndex) {
                // Current step - show current indicator
                currentIcon.classList.remove('hidden');
                currentIcon.classList.add('text-[#047705]');
                iconContainer.classList.add('border-[#047705]', 'bg-[#047705]/10');
            } else if (index < currentStepIndex) {
                // Completed step - show green checkmark
                checkIcon.classList.remove('hidden');
                checkIcon.classList.add('text-[#047705]');
                iconContainer.classList.add('border-[#047705]', 'bg-[#047705]/10');
            }
        }

        const historyRecord = order.status_histories.find(h => h.status.toLowerCase() === step);
        dateElement.textContent = historyRecord ? formatDate(historyRecord.updated_at) : '';
    });

    // Update order details
    const firstItem = order.order_items[0]?.uniform || {};
    document.getElementById('trackingOrderImage').src = firstItem.image_url || '/images/placeholder.png';
    document.getElementById('trackingOrderTitle').textContent = firstItem.name || 'Order Items';
    document.getElementById('trackingOrderNumber').textContent = `Order #${order.order_id}`;
    
    const statusElement = document.getElementById('trackingOrderStatus'); 
        // Check for readytopickup status (case-insensitive) and set text
    const displayStatus = status.toLowerCase() === 'readyforpickup' ? 'Ready for Pickup' : 
        status.charAt(0).toUpperCase() + status.slice(1);
    statusElement.textContent = displayStatus; 
    statusElement.className = `text-xs px-3 py-1 rounded-full text-white ${getStatusColor(status)}`;
    
    document.getElementById('trackingOrderPrice').textContent = `Total: ₱${parseFloat(order.total_price || 0).toFixed(2)}`;
    document.getElementById('trackingOrderDate').textContent = `Ordered: ${formatDate(order.order_date)}`;
    
    const completedRecord = order.status_histories.find(h => h.status.toLowerCase() === 'completed');
    const completedDateEl = document.getElementById('trackingOrderCompletedDate');
    if (completedRecord) {
        completedDateEl.textContent = `Completed: ${formatDate(completedRecord.updated_at)}`;
        completedDateEl.classList.remove('hidden');
    } else {
        completedDateEl.classList.add('hidden');
    }

    const readyforpickupRecord = order.status_histories.find(h => h.status.toLowerCase() === 'readyforpickup');
    document.getElementById('estimatedPickupDate').textContent = readyforpickupRecord ? 
        `Ready by: ${formatDate(readyforpickupRecord.updated_at)}` : 'Not ready yet';

    // Show the tracking container
    userOrdersContainer.classList.remove('hidden');
    emptyState.classList.add('hidden');
}
    
    function attachOrderClickHandlers(orders) {
        document.querySelectorAll('.order-item').forEach(item => {
            item.addEventListener('click', () => {
                const orderId = item.dataset.orderId;
                const selectedOrder = orders.find(o => o.order_id == orderId);
                if (selectedOrder) {
                    updateTrackingProgress(selectedOrder);
                    document.querySelectorAll('.order-item').forEach(el => el.classList.remove('bg-[#2F2E2E]/60'));
                    item.classList.add('bg-[#2F2E2E]/60');
                }
            });
        });
    }

    // Initialize the page
    fetchUserOrders().then(orders => {
        if (orders.length > 0) {
            attachOrderClickHandlers(orders);
            const firstOrderItem = ordersContainer.querySelector('.order-item');
            firstOrderItem?.click();
        }
    });
});

</script>
@endsection