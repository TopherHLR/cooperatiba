@extends('layouts.sharedlayout')

@section('title', 'Items')

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
        /* Background for content section */
        .content-section {
        background-image: url('/images/cooperatibaitems/2ndBG.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>
@endsection

@section('content')
<div class="content-section min-h-screen">
    <div class="content-overlay min-h-screen">
        <div class="flex  mx-10  justify-center gap-10"> <!-- Centered containers -->
            <!-- Left Container - Notifications (20%) -->
            <div class="w-[20%] mt-40 mr-6">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            NOTIFICATIONS
                        </h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Notification Content - Liquid UI Version -->
                    <div class="text-white space-y-4 h-[580px] overflow-y-auto pr-2">
                        <!-- Notification Item 1 - Order -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#EDD100]/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="notification-item bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-3 cursor-pointer transition-all duration-300 relative overflow-hidden"
                                onclick="openNotificationModal('order', 'Your order #12345 is ready', 'Your PE uniform order has been completed and is ready for pickup at the coop office.', '10 mins ago')">
                                <div class="flex items-start z-10 relative">
                                    <div class="bg-[#EDD100]/20 p-2 rounded-lg mr-3 backdrop-blur-sm border border-[#EDD100]/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#EDD100]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <span class="text-xs font-medium text-[#EDD100] bg-[#EDD100]/10 px-2 py-1 rounded-full backdrop-blur-sm">ORDER UPDATE</span>
                                            <span class="text-xs text-gray-400">10 mins ago</span>
                                        </div>
                                        <p class="text-sm font-medium mt-1 line-clamp-2">Your order #12345 is ready for pickup</p>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-[#EDD100] to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                            </div>
                        </div>

                        <!-- Notification Item 2 - Chat -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#047705]/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="notification-item bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-3 cursor-pointer transition-all duration-300 relative overflow-hidden"
                                onclick="openNotificationModal('chat', 'New message from Admin', 'Hello! Just checking if you received your order confirmation. Let us know if you have any questions!', '1 hour ago')">
                                <div class="flex items-start z-10 relative">
                                    <div class="bg-[#047705]/20 p-2 rounded-lg mr-3 backdrop-blur-sm border border-[#047705]/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <span class="text-xs font-medium text-[#047705] bg-[#047705]/10 px-2 py-1 rounded-full backdrop-blur-sm">CHAT MESSAGE</span>
                                            <span class="text-xs text-gray-400">1 hour ago</span>
                                        </div>
                                        <p class="text-sm font-medium mt-1 line-clamp-2">New message from Admin: Hello! Just checking...</p>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-[#047705] to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                            </div>
                        </div>

                        <!-- Notification Item 3 - Promotion -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#8B5CF6]/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="notification-item bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-3 cursor-pointer transition-all duration-300 relative overflow-hidden"
                                onclick="openNotificationModal('promo', 'New Promotion Available', 'Get 15% off on all PE uniforms this week! Limited offer only until Friday.', '2 days ago')">
                                <div class="flex items-start z-10 relative">
                                    <div class="bg-[#8B5CF6]/20 p-2 rounded-lg mr-3 backdrop-blur-sm border border-[#8B5CF6]/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#8B5CF6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <span class="text-xs font-medium text-[#8B5CF6] bg-[#8B5CF6]/10 px-2 py-1 rounded-full backdrop-blur-sm">PROMOTION</span>
                                            <span class="text-xs text-gray-400">2 days ago</span>
                                        </div>
                                        <p class="text-sm font-medium mt-1 line-clamp-2">New Promotion: 15% off on all PE uniforms</p>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-[#8B5CF6] to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notification Modal -->
            <div id="notificationModal" class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/70 hidden">
                <div class="bg-gradient-to-r from-[#1F1E1E] to-[#001C00] border-[.5px] border-white rounded-[30px] p-6 w-full max-w-md relative">
                    <button id="modalCloseBtn" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center mb-4" id="modalHeader">
                        <!-- Icon will be inserted here -->
                        <h3 class="text-xl font-bold text-white ml-3" id="modalTitle">Notification Title</h3>
                    </div>
                    
                    <hr class="border-[.5px] border-white mb-4 -mx-2">
                    
                    <div class="text-white mb-4 text-sm" id="modalContent">
                        Notification content will appear here...
                    </div>
                    
                    <div class="text-right text-xs text-gray-400" id="modalTime">
                        10 mins ago
                    </div>
                </div>
            </div>

            <!-- Right Container - Items (80%) -->
            <div class="w-[80%] mt-40">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Enhanced Cart Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">COOPERATIBA ITEMS</h2>
                        <button class="relative group flex items-center space-x-2 px-4 py-2 rounded-[20px] bg-white/90 hover:bg-white transition-all duration-300 border border-white/30 hover:border-[#047705] shadow-sm">
                            <!-- Cart Icon -->
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705] group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <!-- Cart counter badge -->
                                <span class="absolute -top-2 -right-2 bg-[#EDD100] text-xs text-black font-bold rounded-full h-5 w-5 flex items-center justify-center transform group-hover:scale-125 transition-transform shadow-sm">3</span>
                            </div>
                            
                            <!-- Text label -->
                            <span class="text-[#047705] font-medium text-sm hidden sm:inline-block">Cart</span>
                            
                            <!-- Price indicator - TOP -->
                            <span class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 px-2 py-1 bg-[#047705] text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap shadow-md">
                                ₱1,250.00
                            </span>
                        </button>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Items Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
                        <!-- Product Tile 1 -->
                        <div class="bg-white w-48 h-98 rounded-[15px] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1">
                            <!-- Product Image -->
                            <div class="h-[70%] bg-gray-100/80 flex items-center justify-center p-2 group-hover:bg-gray-100 transition-colors duration-300">
                                <img src="/images/clothes/pe.png" alt="PE Uniform" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <!-- Product Info -->
                            <div class="absolute bottom-0 left-0 right-0 p-3 bg-[#008E01] text-white group-hover:bg-[#007a01] transition-colors duration-300">
                                <h3 class="font-bold text-sm truncate">PE Uniform</h3>
                                <div class="flex justify-between items-center mt-1.5">
                                    <span class="text-xs font-medium">₱250.00</span>
                                    <button onclick="openAddToCartModal('PE Uniform', '₱250.00', '/images/clothes/pe.png')" 
                                            class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <!-- Plus sign -->
                                        <svg class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Tile 2 -->
                        <div class="bg-white w-48 h-98 rounded-[15px] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1">
                            <!-- Product Image -->
                            <div class="h-[70%] bg-gray-100/80 flex items-center justify-center p-2 group-hover:bg-gray-100 transition-colors duration-300">
                                <img src="/images/clothes/pe.png" alt="PE Uniform (Large)" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <!-- Product Info -->
                            <div class="absolute bottom-0 left-0 right-0 p-3 bg-[#008E01] text-white group-hover:bg-[#007a01] transition-colors duration-300">
                                <h3 class="font-bold text-sm truncate">PE Uniform (Large)</h3>
                                <div class="flex justify-between items-center mt-1.5">
                                    <span class="text-xs font-medium">₱275.00</span>
                                    <button class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <!-- Plus sign and cart icon container -->
                                        <div class="relative h-3 w-3 mr-1">
                                            <!-- Plus sign -->
                                            <svg class="absolute top-0 left-0 h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            <!-- Cart icon (smaller and positioned) -->
                                            <svg class="absolute top-0 left-0 h-3 w-3 opacity-0 group-hover:opacity-100 transition-opacity" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                            </svg>
                                        </div>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Add more product tiles as needed -->
                    </div>
                </div>
            </div>
            <!-- Add to Cart Modal -->
            <div id="addToCartModal" class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/70 hidden">
                <div class="bg-gradient-to-r from-[#1F1E1E] to-[#001C00] border-[.5px] border-white rounded-[30px] p-6 w-full max-w-md relative">
                    <button onclick="closeAddToCartModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center mb-4">
                        <div class="bg-[#047705]/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-3" id="cartModalTitle">Add to Cart</h3>
                    </div>
                    
                    <hr class="border-[.5px] border-white mb-4 -mx-2">
                    
                    <div class="text-white mb-4 text-sm">
                        <!-- Product Info -->
                        <div class="flex mb-4">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                <img id="modalProductImage" src="" alt="Product" class="max-h-full max-w-full object-contain">
                            </div>
                            <div>
                                <h4 class="font-bold" id="modalProductName">PE Uniform</h4>
                                <p class="text-[#EDD100] font-medium" id="modalProductPrice">₱250.00</p>
                            </div>
                        </div>
                        
                        <!-- Size Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Select Size</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="XS">XS</button>
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="S">S</button>
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="M">M</button>
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="L">L</button>
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="XL">XL</button>
                                <button class="size-option py-2 px-3 rounded-lg border border-white/30 hover:border-[#047705] transition-all" data-size="XXL">XXL</button>
                            </div>
                            
                            <!-- BMI Recommendation -->
                            <div id="bmiRecommendation" class="mt-3 p-2 bg-[#047705]/10 rounded-lg hidden">
                                <p class="text-xs text-[#EDD100] flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="recommendedSizeText">Based on your BMI, we recommend size <strong>M</strong></span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Quantity -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Quantity</label>
                            <div class="flex items-center">
                                <button id="decrementQty" class="bg-[#047705] text-white w-8 h-8 rounded-l-lg flex items-center justify-center">-</button>
                                <input type="number" id="quantity" value="1" min="1" class="bg-[#1F1E1E] text-white text-center w-12 h-8 border-t border-b border-white/30">
                                <button id="incrementQty" class="bg-[#047705] text-white w-8 h-8 rounded-r-lg flex items-center justify-center">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <button onclick="closeAddToCartModal()" class="px-4 py-2 rounded-lg border text-white border-white/30 hover:bg-white/10 transition-colors">
                            Cancel
                        </button>
                        <button id="proceedToPayment" class="px-4 py-2 rounded-lg bg-[#047705] hover:bg-[#036603] text-white font-medium transition-colors flex items-center">
                            Proceed to Payment
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize modal close button event listener
    document.getElementById('modalCloseBtn').addEventListener('click', closeNotificationModal);
    
    function openNotificationModal(type, title, content, time) {
        const modal = document.getElementById('notificationModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        const modalTime = document.getElementById('modalTime');
        const modalHeader = document.getElementById('modalHeader');
        
        // Set modal content
        modalTitle.textContent = title;
        modalContent.textContent = content;
        modalTime.textContent = time;
        
        // Set icon based on notification type
        let iconHtml = '';
        
        switch(type) {
            case 'order':
                iconHtml = `
                    <div class="bg-[#EDD100]/20 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#EDD100]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                `;
                break;
            case 'chat':
                iconHtml = `
                    <div class="bg-[#047705]/20 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                `;
                break;
            case 'promo':
                iconHtml = `
                    <div class="bg-[#8B5CF6]/20 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#8B5CF6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </div>
                `;
                break;
        }
        
        // Keep the title element and just prepend the icon
        const titleElement = modalHeader.querySelector('h3');
        modalHeader.innerHTML = iconHtml;
        modalHeader.appendChild(titleElement);
        
        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeNotificationModal() {
        document.getElementById('notificationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    // Function to open the add to cart modal
    function openAddToCartModal(productName, productPrice, productImage) {
        const modal = document.getElementById('addToCartModal');
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductPrice').textContent = productPrice;
        document.getElementById('modalProductImage').src = productImage;
        
        // Show BMI recommendation (simulated - in real app you would calculate BMI)
        const bmiRecommendation = document.getElementById('bmiRecommendation');
        bmiRecommendation.classList.remove('hidden');
        
        // Simulate BMI calculation (replace with actual BMI logic)
        const recommendedSize = calculateRecommendedSize(); 
        document.getElementById('recommendedSizeText').innerHTML = 
            `Based on your BMI, we recommend size <strong>${recommendedSize}</strong>`;
        
        // Highlight recommended size
        document.querySelectorAll('.size-option').forEach(btn => {
            if(btn.dataset.size === recommendedSize) {
                btn.classList.add('bg-[#047705]', 'border-[#047705]');
                btn.classList.remove('border-white/30');
            }
        });
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Function to close the modal
    function closeAddToCartModal() {
        document.getElementById('addToCartModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Simulated BMI calculation (replace with real calculation)
    function calculateRecommendedSize() {
        // This is a placeholder - in a real app you would:
        // 1. Get user's height/weight from profile
        // 2. Calculate BMI (weight kg / (height m)^2)
        // 3. Return size recommendation based on BMI ranges
        
        const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        const randomIndex = Math.floor(Math.random() * sizes.length); // Simulate different recommendations
        return sizes[randomIndex];
    }
    
    // Event listeners for quantity buttons
    document.getElementById('incrementQty').addEventListener('click', () => {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    });
    
    document.getElementById('decrementQty').addEventListener('click', () => {
        const input = document.getElementById('quantity');
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });
    
    // Size selection
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(b => {
                b.classList.remove('bg-[#047705]', 'border-[#047705]');
                b.classList.add('border-white/30');
            });
            this.classList.add('bg-[#047705]', 'border-[#047705]');
            this.classList.remove('border-white/30');
        });
    });
    
    // Proceed to payment
    document.getElementById('proceedToPayment').addEventListener('click', function() {
        const selectedSize = document.querySelector('.size-option.bg-[#047705]')?.dataset.size || 'Not selected';
        const quantity = document.getElementById('quantity').value;
        
        alert(`Proceeding to payment with:\nProduct: ${document.getElementById('modalProductName').textContent}\nSize: ${selectedSize}\nQuantity: ${quantity}`);
        closeAddToCartModal();
    });
</script>
@endsection