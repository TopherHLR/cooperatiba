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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-3" id="cartModalTitle">Buy Now</h3>
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