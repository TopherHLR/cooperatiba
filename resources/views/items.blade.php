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
</style>
@endsection

@section('content')
<div  class=" content-section flex mx-10 justify-center  min-h-full">
    <div  class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px]  w-[100%] mt-32 mb-10 h-full backdrop-blur-sm flex flex-col">
        @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 2500)" 
                x-show="show"
                x-transition
                class="fixed top-20 left-1/2 transform -translate-x-1/2 w-[90%] z-[1000] bg-green-100 border border-green-400 text-green-700 rounded p-4 shadow-lg"
            >
                {{ session('success') }}
            </div>
        @endif
        <div class="flex mx-10 justify-center mb-10 gap-10">
            <!-- Left Container - Notifications (20%) -->
            <div class="w-[20%] mt-10 mr-6">
                <div class="liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
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
                    @if(auth()->check() && auth()->user()->role === 'student')
                        <!-- Notification Content - Liquid UI Version -->
                        <div class="text-white space-y-4 h-[580px] overflow-y-auto pr-2" id="notification-container">
                            <!-- Notifications will be dynamically loaded here -->
                        </div>
                    @elseif(!auth()->check())
                        <!-- Show login first message -->
                        <div class="text-white text-center h-[580px] flex items-center justify-center">
                            <p>Please log in to view notifications.</p>
                        </div>
                    @endif

                </div>    
            </div>

            <!-- Right Container - Items (80%) -->
            <div class="w-[80%] mt-10">
                <div class="liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Enhanced Cart Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">COOPERATIBA ITEMS</h2>
                        @if(auth()->check() && auth()->user()->role === 'student')

                            <button onclick="openCartModal()" class="relative group flex items-center space-x-2 px-4 py-2 rounded-[20px] bg-white/90 hover:bg-white transition-all duration-300 border border-white/30 hover:border-[#047705] shadow-sm">
                                @php
                                    $cartItems = \App\Models\CartsModel::with('uniform')->where('user_id', auth()->id())->get();
                                    $cartItemCount = $cartItems->sum('quantity');
                                    $cartTotal = $cartItems->sum(function ($item) {
                                        return optional($item->uniform)->price * $item->quantity;
                                    });
                                @endphp
                    
                                <!-- Cart Icon -->
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705] group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <!-- Cart counter badge -->
                                    <span id="cartCounter" class="absolute -top-2 -right-2 bg-[#EDD100] text-xs text-black font-bold rounded-full h-5 w-5 flex items-center justify-center transform group-hover:scale-125 transition-transform shadow-sm">
                                        {{ $cartItemCount }}
                                    </span>                      
                                </div>
                                <span class="text-[#047705] font-medium text-sm hidden sm:inline-block">Cart</span>
                                <span class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 px-2 py-1 bg-[#047705] text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap shadow-md">
                                    <span id="cartTotal">{{ number_format($cartTotal, 2) }}</span>
                                </span>
                            </button>
                        @endif
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Items Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
                        @foreach($uniforms as $uniform)
                        <div class="bg-white w-58 h-108 rounded-[15px] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1">
                            <!-- Product Image -->
                            <div class="h-[70%] bg-gray-100/80 flex items-center justify-center p-2 group-hover:bg-gray-100 transition-colors duration-300 cursor-pointer" 
                                onclick="openImageGalleryModal('{{ $uniform->name }}')">
                                <img id="galleryImages" src="{{ $uniform->image_url }}" alt="{{ $uniform->name }}" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <!-- Product Info -->   
                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-[#008E01] text-white group-hover:bg-[#007a01] transition-colors duration-300">
                                    <h3 class="font-bold text-sm truncate">{{ $uniform->name }}</h3>
                                <div class="flex justify-between items-center mt-1.5">
                                    <span class="text-xs font-medium">₱{{ number_format($uniform->price, 2) }}</span>
                                    <button onclick="openAddToCartModal('{{ $uniform->name }}', '₱{{ number_format($uniform->price, 2) }}', '{{ $uniform->image_url }}', '{{ $uniform->uniform_id }}')" 
                                            class="flex items-center ms-1 justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <svg class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Add</span>
                                    </button>
                                    <button onclick="openBuyerModal('{{ $uniform->uniform_id }}', '{{ $uniform->name }}', '₱{{ number_format($uniform->price, 2) }}', '{{ $uniform->image_url }}')" 
                                            class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span>Buy</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('uniforms.modals', ['student' => $student])


<script src="//unpkg.com/alpinejs" defer></script>

<!-- JavaScript -->
<script>
    
    let currentImageIndex = 0;
    let galleryImages = [];

    const productGalleryImages = {
        "Womens University Uniform": [
            "/images/clothes/franz.png",
            "/images/clothes/womensunif.png",
            "/images/clothes/realwomensunif1.png",
            "/images/clothes/realwomensunif2.png"
        ],
        "Mens University Uniform": [
            "/images/clothes/topher.png",
            "/images/clothes/mensunif.png",
            "/images/clothes/realmenunif1.png",
            "/images/clothes/realmenunif2.png"
        ],
        "PE Uniform": [
            "/images/clothes/kurt.png",
            "/images/clothes/pe.png",
            "/images/clothes/realpe1.png",
            "/images/clothes/realpe2.png"
        ]
        // You can add more mappings here
    };

    function openImageGalleryModal(productName, fallbackImages = []) {
        const modal = document.getElementById('imageGalleryModal');

        // Set product name
        document.getElementById('galleryProductName').textContent = productName;

        // Determine images
        const images = productGalleryImages[productName] || fallbackImages;

        // Set main image
        const mainImage = document.getElementById('galleryMainImage');
        mainImage.src = images[0];
        mainImage.alt = `${productName} - Image 1`;

        // Set thumbnails
        const thumbnailTrack = document.getElementById('thumbnailTrack');
        thumbnailTrack.innerHTML = '';

        images.forEach((imgUrl, index) => {
            const thumb = document.createElement('img');
            thumb.src = imgUrl;
            thumb.alt = `${productName} - Thumbnail ${index + 1}`;
            thumb.className = 'h-20 w-20 object-contain border rounded-lg cursor-pointer hover:scale-105 transition-transform';
            thumb.onclick = () => {
                mainImage.src = imgUrl;
                mainImage.alt = `${productName} - Image ${index + 1}`;
            };
            thumbnailTrack.appendChild(thumb);
        });

        modal.classList.remove('hidden');
    }


    function updateMainImage() {
        const mainImage = document.getElementById('galleryMainImage');
        mainImage.src = galleryImages[currentImageIndex];
        mainImage.alt = `Image ${currentImageIndex + 1}`;

        // Update selected thumbnail border
        const thumbnails = document.querySelectorAll('#thumbnailTrack img');
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('border-white', i === currentImageIndex);
            thumb.classList.toggle('border-white/30', i !== currentImageIndex);
        });
    }

    function showPreviousImage() {
        if (currentImageIndex > 0) {
            currentImageIndex--;
            updateMainImage();
        }
    }

    function showNextImage() {
        if (currentImageIndex < galleryImages.length - 1) {
            currentImageIndex++;
            updateMainImage();
        }
    }

    // Modal control functions
    function closeAddToCartModal() {
        document.getElementById('addToCartModal').classList.add('hidden');
    }

    function closeBuyModal() {
        document.getElementById('openBuyModal').classList.add('hidden');
    }


    function closeImageGalleryModal() {
        document.getElementById('imageGalleryModal').classList.add('hidden');
    }

    function openAddToCartModal(productName, productPrice, productImage, productId) {
        console.log('openAddToCartModal called');

        const modal = document.getElementById('addToCartModal');

        // Populate modal content
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductPrice').textContent = productPrice;
        document.getElementById('modalProductImage').src = productImage;

        // Correctly assign product ID to the input
        document.getElementById('uniformIdInput').value = productId;

        // Show the modal
        modal.classList.remove('hidden');
    }


    function openBuyerModal(uniformId, uniformName, price, imageUrl) {
        // Set hidden inputs
        document.getElementById('uniformIdInput').value = uniformId;
        document.getElementById('selectedSizeInput').value = 'M';
        document.getElementById('selectedQtyInput').value = 1;

        // Update modal display
        document.getElementById('modalProductNameBuy').textContent = uniformName;
        document.getElementById('modalProductPriceBuy').textContent = `${price}`;
        document.getElementById('modalProductImageBuy').src = imageUrl;
                // Set form action dynamically using query parameters
        const form = document.getElementById('buyNowForm');
        const size = document.getElementById('selectedSizeInput').value;
        const quantity = document.getElementById('selectedQtyInput').value;
        const paymentMethod = document.getElementById('selectedPaymentInput').value;

        form.action = `/payment/${uniformId}?size=${size}&quantity=${quantity}&payment_method=${encodeURIComponent(paymentMethod)}`;
        // Show the modal
        document.getElementById('openBuyModal').classList.remove('hidden');
    }


    
    async function fetchNotifications() {
        try {
            const response = await fetch('/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.status === 'success') {
                renderNotifications(data.data);
            }
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    function renderNotifications(notifications) {
        const container = document.getElementById('notification-container');
        container.innerHTML = '';

        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-400 py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                    </svg>
                    <p class="text-sm">No notifications at the moment.</p>
                </div>
            `;
        } else {
            notifications.forEach(notification => {
                const notificationHtml = `
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-[${notification.color}]/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="notification-item bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-xl p-3 cursor-pointer transition-all duration-300 relative overflow-hidden"
                            onclick="openNotificationModal('${notification.type}', '${notification.title}', '${notification.message}', '${notification.time_ago}')">
                            <div class="flex items-start z-10 relative">
                                <div class="bg-[${notification.color}]/20 p-2 rounded-lg mr-3 backdrop-blur-sm border border-[${notification.color}]/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[${notification.color}]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${notification.icon}" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <span class="text-xs font-medium text-[${notification.color}] bg-[${notification.color}]/10 px-2 py-1 rounded-full backdrop-blur-sm">${notification.type}</span>
                                        <span class="text-xs text-gray-400">${notification.time_ago}</span>
                                    </div>
                                    <p class="text-sm font-medium mt-1 line-clamp-2">${notification.message}</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-[${notification.color}] to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                        </div>
                    </div>
                `;
                container.innerHTML += notificationHtml;
            });
        }
    }

    // Fetch notifications on page load
    document.addEventListener('DOMContentLoaded', fetchNotifications);

</script>
@endsection
