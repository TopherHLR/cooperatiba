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
            <!-- Global Cart Modal -->
            <div id="cartModal" class="fixed inset-0 z-[2000] flex items-center justify-center bg-black/70 hidden">
                <div class="bg-gradient-to-r from-[#1F1E1E] to-[#001C00] border-[.5px] border-white rounded-[30px] p-6 w-full max-w-2xl mx-4 relative animate-float">
                    <!-- Close Button -->
                    <button onclick="closeCartModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <!-- Header -->
                    <div class="flex items-center mb-4">
                        <div class="bg-[#047705]/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-3">Your Cart</h3>
                        <span id="cartItemCount" class="ml-2 text-sm text-gray-300">(3 items)</span>
                    </div>
                    
                    <hr class="border-[.5px] border-white mb-4 -mx-2">
                    
                    <!-- Cart Items -->
                    <div class="max-h-[60vh] overflow-y-auto scrollbar-hide">
                        <!-- Sample Cart Item - Now Selectable -->
                        <div class="flex items-center justify-between py-3 border-b border-white/10 hover:bg-white/5 transition-colors">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" class="h-5 w-5 rounded border-gray-300 text-[#047705] focus:ring-[#047705]" unchecked>
                                <div class="flex items-center space-x-4">
                                    <img src="/images/clothes/pe.png" alt="Product" class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h4 class="text-white font-medium">Product Name</h4>
                                        <p class="text-sm text-gray-400">₱350.00 × 2</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-white font-medium">₱700.00</span>
                                <button class="text-red-400 hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Second Sample Cart Item -->
                        <div class="flex items-center justify-between py-3 border-b border-white/10 hover:bg-white/5 transition-colors">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" class="h-5 w-5 rounded border-gray-300 text-[#047705] focus:ring-[#047705]" unchecked>
                                <div class="flex items-center space-x-4">
                                    <img src="/images/clothes/pe.png" alt="Product" class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h4 class="text-white font-medium">Another Product</h4>
                                        <p class="text-sm text-gray-400">₱550.00 × 1</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-white font-medium">₱550.00</span>
                                <button class="text-red-400 hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart Summary -->
                    <div class="mt-6 pt-4 border-t border-white/10">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-400">Subtotal (2 items):</span>
                            <span class="text-white font-medium">₱1,250.00</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-400">Shipping:</span>
                            <span class="text-white font-medium">₱0.00</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="text-white">Total:</span>
                            <span class="text-[#EDD100] font-bold">₱1,250.00</span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-between mt-6">
                            <button onclick="selectAllItems()" class="py-2 px-4 border border-white/30 hover:bg-white/10 text-white rounded-lg transition-colors">
                                Select All
                            </button>
                            <div class="space-x-3">
                                <button onclick="removeSelected()" class="py-2 px-4 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition-colors">
                                    Remove Selected
                                </button>
                                <a href="{{ route('web.payment') }}" class="py-3 px-6 bg-[#047705] hover:bg-[#036504] text-white font-bold rounded-lg transition-colors">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Container - Items (80%) -->
            <div class="w-[80%] mt-40">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Enhanced Cart Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">COOPERATIBA ITEMS</h2>
                        <button class="relative group flex items-center space-x-2 px-4 py-2 rounded-[20px] bg-white/90 hover:bg-white transition-all duration-300 border border-white/30 hover:border-[#047705] shadow-sm">                            <!-- Cart Icon -->
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
                        <div class="bg-white w-58 h-108 rounded-[15px] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1">
                            <!-- Product Image - Now clickable -->
                            <div class="h-[70%] bg-gray-100/80 flex items-center justify-center p-2 group-hover:bg-gray-100 transition-colors duration-300 cursor-pointer" 
                                onclick="openImageGalleryModal('PE Uniform', ['/images/clothes/pe.png', '/images/clothes/pe2.png', '/images/clothes/pe3.png'])">
                                <img src="/images/clothes/pe.png" alt="PE Uniform" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <!-- Product Info -->
                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-[#008E01] text-white group-hover:bg-[#007a01] transition-colors duration-300">
                                <h3 class="font-bold text-sm truncate">PE Uniform</h3>
                                <div class="flex justify-between items-center mt-1.5">
                                    <span class="text-xs font-medium">₱250.00</span>
                                    <button onclick="openAddToCartModal('PE Uniform', '₱250.00', '/images/clothes/pe.png')" 
                                            class="flex items-center ms-1 justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <!-- Plus sign -->
                                        <svg class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Add</span>
                                    </button>
                                    <button onclick="openBuyerModal('PE Uniform', '₱250.00', '/images/clothes/pe.png')" 
                                            class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <!-- Shopping bag icon -->
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                            Add to Cart
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- buy Modal -->
            <div id="openBuyModal" class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/70 hidden">
                <div class="bg-gradient-to-r from-[#1F1E1E] to-[#001C00] border-[.5px] border-white rounded-[30px] p-6 w-full max-w-md relative">
                    <button onclick="closeBuyModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
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
                        <button onclick="closeBuyModal()" class="px-4 py-2 rounded-lg border text-white border-white/30 hover:bg-white/10 transition-colors">
                            Cancel
                        </button>
                        <a href="{{ route('web.payment') }}" 
                        class="px-4 py-2 rounded-lg bg-[#047705] hover:bg-[#036603] text-white font-medium transition-colors flex items-center">
                            Buy now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Liquid UI Image Gallery Modal -->
            <div id="imageGalleryModal" class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/70 hidden">
                <div class="bg-gradient-to-r from-[#1F1E1E] to-[#001C00] border-[.5px] border-white rounded-[30px] p-8 w-full max-w-3xl mx-4 relative">
                    <!-- Close Button (Matched to Buy Modal) -->
                    <button onclick="closeImageGalleryModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <!-- Header (Matched Style) -->
                    <div class="flex items-center mb-4">
                        <div class="bg-[#047705]/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-3">Product Gallery</h3>
                    </div>
                    
                    <hr class="border-[.5px] border-white mb-4 -mx-2">
                    
                    <!-- Main Content Area -->
                    <div class="text-white">
                        <!-- Main Image Container -->
                        <div class="relative mb-4 rounded-xl overflow-hidden bg-[#1F1E1E] border border-white/20">
                            <img id="galleryMainImage" src="" alt="" class="w-full h-auto max-h-[45vh] object-contain mx-auto">
                            
                            <!-- Loading Indicator (Matched Style) -->
                            <div id="galleryLoader" class="absolute inset-0 flex items-center justify-center bg-black/50 hidden">
                                <div class="relative w-16 h-16">
                                    <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-[#047705] border-r-[#047705] animate-spin"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        <div class="relative">
                            <!-- Gradient Fade Edges -->
                            <div class="absolute left-0 top-0 bottom-0 w-10 bg-gradient-to-r from-[#1F1E1E] to-transparent z-10 pointer-events-none"></div>
                            <div class="absolute right-0 top-0 bottom-0 w-10 bg-gradient-to-l from-[#1F1E1E] to-transparent z-10 pointer-events-none"></div>
                            
                            <!-- Thumbnail Track -->
                            <div id="thumbnailTrack" class="flex space-x-3 overflow-x-auto scroll-smooth py-2 scrollbar-hide -mx-2 px-2">
                                <!-- Thumbnails will be injected here by JavaScript -->
                            </div>
                        </div>
                        
                        <!-- Navigation Arrows (Matched Style) -->
                        <div class="flex justify-between mt-4">
                            <button id="prevImage" class="px-3 py-1 rounded-lg border text-white border-white/30 hover:bg-white/10 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>
                            <button id="nextImage" class="px-3 py-1 rounded-lg border text-white border-white/30 hover:bg-white/10 transition-colors flex items-center">
                                Next
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    // Initialize modal close button event listener
    document.getElementById('modalCloseBtn').addEventListener('click', closeNotificationModal);
    
    // Notification Modal Functions
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

    // Buy Modal Functions
    function openBuyerModal(productName, productPrice, productImage) {
        const modal = document.getElementById('openBuyModal');
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductPrice').textContent = productPrice;
        document.getElementById('modalProductImage').src = productImage;
        
        // Show BMI recommendation
        const bmiRecommendation = document.getElementById('bmiRecommendation');
        bmiRecommendation.classList.remove('hidden');
        
        // Calculate and display recommended size
        const recommendedSize = calculateRecommendedSize(); 
        document.getElementById('recommendedSizeText').innerHTML = 
            `Based on your BMI, we recommend size <strong>${recommendedSize}</strong>`;
        
        // Highlight recommended size
        document.querySelectorAll('.size-option').forEach(btn => {
            btn.classList.remove('bg-[#047705]', 'border-[#047705]');
            btn.classList.add('border-white/30');
            
            if(btn.dataset.size === recommendedSize) {
                btn.classList.add('bg-[#047705]', 'border-[#047705]');
                btn.classList.remove('border-white/30');
            }
        });
        
        // Reset quantity to 1
        document.getElementById('quantity').value = 1;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeBuyModal() {
        document.getElementById('openBuyModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Add to Cart Modal Functions
    function openAddToCartModal(productName, productPrice, productImage) {
        const modal = document.getElementById('addToCartModal');
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductPrice').textContent = productPrice;
        document.getElementById('modalProductImage').src = productImage;
        
        // Show BMI recommendation
        const bmiRecommendation = document.getElementById('bmiRecommendation');
        bmiRecommendation.classList.remove('hidden');
        
        // Calculate and display recommended size
        const recommendedSize = calculateRecommendedSize(); 
        document.getElementById('recommendedSizeText').innerHTML = 
            `Based on your BMI, we recommend size <strong>${recommendedSize}</strong>`;
        
        // Highlight recommended size
        document.querySelectorAll('.size-option').forEach(btn => {
            btn.classList.remove('bg-[#047705]', 'border-[#047705]');
            btn.classList.add('border-white/30');
            
            if(btn.dataset.size === recommendedSize) {
                btn.classList.add('bg-[#047705]', 'border-[#047705]');
                btn.classList.remove('border-white/30');
            }
        });
        
        // Reset quantity to 1
        document.getElementById('quantity').value = 1;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeAddToCartModal() {
        document.getElementById('addToCartModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Shared Functions
    function calculateRecommendedSize() {
        const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        const randomIndex = Math.floor(Math.random() * sizes.length);
        return sizes[randomIndex];
    }
        // Image Gallery Modal Functions
    function openImageGalleryModal(productName, images) {
    const modal = document.getElementById('imageGalleryModal');
    const mainImage = document.getElementById('galleryMainImage');
    const thumbnailContainer = document.getElementById('thumbnailTrack'); // Changed selector
    
    // Set the first image as main
    mainImage.src = images[0];
    mainImage.alt = productName;
    
    // Clear any existing thumbnails
    thumbnailContainer.innerHTML = '';
    
    // Add thumbnails
    images.forEach((image, index) => {
        const thumbnail = document.createElement('img');
        thumbnail.src = image;
        thumbnail.alt = `${productName} - View ${index + 1}`;
        thumbnail.className = 'w-16 h-16 object-cover cursor-pointer border-2 border-transparent hover:border-[#047705] rounded';
        thumbnail.onclick = () => {
            mainImage.src = image;
            // Highlight selected thumbnail
            thumbnailContainer.querySelectorAll('img').forEach(img => {
                img.classList.remove('border-[#047705]');
                img.classList.add('border-transparent');
            });
            thumbnail.classList.add('border-[#047705]');
            thumbnail.classList.remove('border-transparent');
        };
        
        // Highlight first thumbnail by default
        if (index === 0) {
            thumbnail.classList.add('border-[#047705]');
            thumbnail.classList.remove('border-transparent');
        }
        
        thumbnailContainer.appendChild(thumbnail);
    });
    
    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
    function closeImageGalleryModal() {
        document.getElementById('imageGalleryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    // Cart Modal Functions
    function openCartModal() {
        document.getElementById('cartModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCartModal() {
        document.getElementById('cartModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    function selectAllItems() {
        const checkboxes = document.querySelectorAll('#cartModal input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateCartSummary();
    }
    
    function removeSelected() {
        const checkboxes = document.querySelectorAll('#cartModal input[type="checkbox"]:checked');
        checkboxes.forEach(checkbox => {
            // In a real implementation, you would remove the item from the cart
            // Here we'll just remove the DOM element
            checkbox.closest('.border-b').remove();
        });
        updateCartSummary();
    }
    
    function updateCartSummary() {
        // In a real implementation, you would recalculate totals based on selected items
        // This is just a placeholder for the functionality
        const selectedCount = document.querySelectorAll('#cartModal input[type="checkbox"]:checked').length;
        document.querySelector('#cartItemCount').textContent = `(${selectedCount} items)`;
    }
    
    // Add event listeners to checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('#cartModal input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCartSummary);
        });
    });
    // Make the cart button open the modal
    document.addEventListener('DOMContentLoaded', function() {
        const cartButton = document.querySelector('.relative.group.flex.items-center.space-x-2'); // Target your cart button
        if (cartButton) {
            cartButton.addEventListener('click', openCartModal);
        }
    });
    // Event listeners for quantity buttons (shared between modals)
    document.getElementById('incrementQty')?.addEventListener('click', () => {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    });
    
    document.getElementById('decrementQty')?.addEventListener('click', () => {
        const input = document.getElementById('quantity');
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });
    
    // Size selection (shared between modals)
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
    
    // Proceed to payment (for add to cart modal)
    document.getElementById('proceedToPayment')?.addEventListener('click', function() {
        const selectedSize = document.querySelector('.size-option.bg-[#047705]')?.dataset.size || 'Not selected';
        const quantity = document.getElementById('quantity').value;
        
        alert(`Proceeding to payment with:\nProduct: ${document.getElementById('modalProductName').textContent}\nSize: ${selectedSize}\nQuantity: ${quantity}`);
        closeAddToCartModal();
    });

</script>
@endsection