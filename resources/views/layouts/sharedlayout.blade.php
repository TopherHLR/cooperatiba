<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cooperatiba')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
                /* Liquid UI Background Effects */
    body {
        background: linear-gradient(135deg, #1F1E1E 0%, #001C00 100%);
        min-height: 100vh;
        font-family: 'Inria Sans', sans-serif;
        overflow-x: hidden;
    }
    .content-section {
        background-image: url('/images/cooperatibaitems/2ndBG.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
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
    .glowing-icon {
        animation: glowColors 3s infinite ease-in-out;
        filter: drop-shadow(0 0 5px #00ffcc);
    }

    @keyframes glowColors {
        0% { stroke: #00ffcc; filter: drop-shadow(0 0 5px #00ffcc); }
        50% { stroke: #00ff00; filter: drop-shadow(0 0 6px #00ff00); }
        100% { stroke: #00ffcc; filter: drop-shadow(0 0 5px #00ffcc); }
    }
    @keyframes liquidFlow {
        0% { transform: rotate(30deg) translate(-10%, -10%); }
        50% { transform: rotate(30deg) translate(10%, 10%); }
        100% { transform: rotate(30deg) translate(-10%, -10%); }
    }      
        /* Liquid UI Navigation Effects */
        .nav-link {
            position: relative;
            overflow: hidden;
            padding: 0.5rem 1rem;
            transition: all 0.4s ease;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width:  0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #EDD100, transparent);
            transition: width 0.4s ease;
        }
        
        .nav-link:hover::before {
            width: 100%;
        }
        
        .nav-link.active {
            color: #EDD100;
        }
        
        .nav-link.active::before {
            width: 100%;
            background: #EDD100;
        }
                /* Add this to your existing styles */
        .nav-link-footer {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .nav-link-footer:hover {
            transform: translateY(-2px);
            text-shadow: 0 2px 4px rgba(237, 209, 0, 0.4);
        }
        
        @keyframes cardShine {
            0% { opacity: 0.3; }
            50% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }
        /* Ripple effect */
        .nav-link::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(237, 209, 0, 0.4);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
            transition: all 0.6s ease;
        }
        
        .nav-link:hover::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.4;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        /* Navbar glow effect */
        .gh {
            box-shadow: 0 4px 30px rgba(0, 123, 0, 0.3);
            transition: box-shadow 0.5s ease;
        }
        
        .gh:hover {
            box-shadow: 0 4px 40px rgba(0, 123, 0, 0.5);
        }
        /* Liquid UI Background Effects */
        body {
            background: linear-gradient(135deg, #1F1E1E 0%, #001C00 100%);
            min-height: 100vh;
            font-family: 'Inria Sans', sans-serif;
            overflow-x: hidden;
        }
        .content-section {
            background-image: url('/images/cooperatibaitems/2ndBG.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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
                rgba(18, 108, 7, 0.15) 0%,
                rgba(113, 200, 98, 0.15) 25%,
                rgba(210, 220, 50, 0.12) 50%,
                rgba(113, 200, 98, 0.15) 75%,
                rgba(10, 56, 14, 0.15) 100%
            );
            transform: rotate(30deg);
            animation: liquidFlow 15s linear infinite;
            z-index: -1;
            opacity: 0.5;
        }
        .glowing-icon {
            animation: glowColors 3s infinite ease-in-out;
            filter: drop-shadow(0 0 5px #00ffcc);
        }

        @keyframes glowColors {
            0% { stroke: #00ffcc; filter: drop-shadow(0 0 5px #00ffcc); }
            50% { stroke: #00ff00; filter: drop-shadow(0 0 6px #00ff00); }
            100% { stroke: #00ffcc; filter: drop-shadow(0 0 5px #00ffcc); }
        }
        @keyframes liquidFlow {
            0% { transform: rotate(30deg) translate(-10%, -10%); }
            50% { transform: rotate(30deg) translate(10%, 10%); }
            100% { transform: rotate(30deg) translate(-10%, -10%); }
        }
        /* Liquid UI Navigation Effects */
        .nav-link {
            position: relative;
            overflow: hidden;
            padding: 0.5rem 1rem;
            transition: all 0.4s ease;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #EDD100, transparent);
            transition: width 0.4s ease;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link.active {
            color: #EDD100;
        }

        .nav-link.active::before {
            width: 100%;
            background: #EDD100;
        }
        /* Add this to your existing styles */
        .nav-link-footer {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .nav-link-footer:hover {
            transform: translateY(-2px);
            text-shadow: 0 2px 4px rgba(237, 209, 0, 0.4);
        }

        @keyframes cardShine {
            0% { opacity: 0.3; }
            50% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }
        /* Ripple effect */
        .nav-link::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(237, 209, 0, 0.4);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
            transition: all 0.6s ease;
        }

        .nav-link:hover::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.4;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        

        /* Navbar glow effect */
        .gh {
            box-shadow: 0 4px 30px rgba(0, 123, 0, 0.3);
            transition: box-shadow 0.5s ease;
        }

        .gh:hover {
            box-shadow: 0 4px 40px rgba(0, 123, 0, 0.5);
        }
        /* Theme Toggle Switch */
        .liquid-toggle-switch {
            position: relative;
            display: inline-block;
            width: 28px;
            height: 50px;
            cursor: pointer;
            vertical-align: middle;
        }

        .liquid-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .liquid-slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, #1F1E1E 0%, #001C00 100%);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 28, 0, 0.3);
        }

        .liquid-slider::before {
            position: absolute;
            content: '';
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
            border-radius: 50%;
            transition: all 0.4s ease;
            box-shadow: 0 2px 8px rgba(4, 119, 5, 0.4);
        }

        .liquid-toggle-switch input:checked + .liquid-slider::before {
            transform: translateY(-26px);
        }

        .liquid-toggle-switch input:checked + .liquid-slider {
            background: linear-gradient(180deg, #ffffff 0%, #e0e0e0 100%);
            border: 1px solid rgba(4, 119, 5, 0.3);
        }

        /* Slider Icon */
        .slider-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            transition: color 0.4s ease;
        }

        .liquid-toggle-switch input:checked + .liquid-slider .slider-icon {
            color: #1F1E1E;
            content: '☀️';
        }

        .liquid-toggle-switch input:not(:checked) + .liquid-slider .slider-icon {
            content: '🌙';
        }

        /* Light Mode Styles */
        .light-mode {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%) !important;
            color: #1F1E1E !important;
        }

        .light-mode .liquid-card,
        .light-mode .liquid-table,
        .light-mode .liquid-modal {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #1F1E1E !important;
        }
                /* Light Mode Styles */
        .light-mode .account-liquid-card {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(31, 30, 30, 0.2) !important;
            color: #1F1E1E !important;
        }

        .light-mode .account-liquid-card h2,
        .light-mode .account-nav-btn {
            color: #1F1E1E !important;
        }

        .light-mode .account-nav-btn {
            background: linear-gradient(90deg, rgba(4, 119, 5, 0.2) 0%, rgba(4, 119, 5, 0.4) 100%) !important;
        }

        .light-mode .account-nav-btn:hover {
            color: #047705 !important;
        }


        .light-mode .liquid-table thead {
            background: linear-gradient(90deg, #047705 0%, #0aad0a 100%) !important;
        }

        .light-mode .liquid-btn,
        .light-mode .modal-liquid-btn-primary {
            background: linear-gradient(90deg, #047705 0%, #0aad0a 100%) !important;
        }

        .light-mode .text-white {
            color: #1F1E1E !important;
        }

        .light-mode .liquid-input {
            background: rgba(0, 0, 0, 0.05) !important;
            color: #1F1E1E !important;
        }

        .light-mode .liquid-label {
            color: #1F1E1E !important;
        }

        .light-mode .nav-link,
        .light-mode .item-button,
        .light-mode .nav-link-cart,
        .light-mode .nav-link-chat,
        .light-mode .nav-link-notification {
            color: white !important; /* Changed to white for light mode */
            text-shadow: 0 0 2px rgba(0, 0, 0, 0.3) !important; /* Optional: Add subtle shadow for readability */
        }

        .light-mode .glowing-icon {
            stroke: #1F1E1E !important;
        }
        /* Light mode variant */
        .light-mode .liquid-account-card {
            background:rgba(255, 255, 255, 0.9) !important;
            border: 0.5px solid rgba(31, 30, 30, 0.2) !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
            color: #1F1E1E !important;
        }
        /* Tooltip for accessibility */
        .group:hover .liquid-toggle-switch::after {
            content: 'Toggle Theme';
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background: #047705;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            font-family: 'Inria Sans', sans-serif;
            white-space: nowrap;
        }
        /* Notification Modal Container */
        .notification-modal-container {
            background: linear-gradient(to right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 24px;
            width: 100%;
            max-width: 400px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .light-mode .notification-modal-container {
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Cart Modal Container */
        .cart-modal-container {
            background: linear-gradient(to right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 24px;
            width: 100%;
            max-width: 32rem;
            position: relative;
        }

        .light-mode .cart-modal-container {
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Add to Cart Modal Container */
        .add-to-cart-modal-container {
            background: linear-gradient(to right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 24px;
            width: 100%;
            max-width: 28rem;
            position: relative;
        }

        .light-mode .add-to-cart-modal-container {
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Buy Modal Container */
        .buy-modal-container {
            background: linear-gradient(to right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 24px;
            width: 100%;
            max-width: 28rem;
            position: relative;
        }

        .light-mode .buy-modal-container {
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Image Gallery Modal Container */
        .image-gallery-modal-container {
            background: linear-gradient(to right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 32px;
            width: 100%;
            max-width: 48rem;
            position: relative;
        }

        .light-mode .image-gallery-modal-container {
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Fullscreen Notification Modal Container */
        .fullscreen-notification-modal-container {
            background: linear-gradient(to bottom right, #1F1E1E, #001C00);
            border: 0.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 24px;
            width: 100%;
            max-width: 48rem;
            height: 80vh;
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .light-mode .fullscreen-notification-modal-container {
            background: linear-gradient(to bottom right, #ffffff, #e0e0e0);
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Adjust text colors for light mode */
        .light-mode .notification-modal-container .text-white,
        .light-mode .cart-modal-container .text-white,
        .light-mode .add-to-cart-modal-container .text-white,
        .light-mode .buy-modal-container .text-white,
        .light-mode .image-gallery-modal-container .text-white,
        .light-mode .fullscreen-notification-modal-container .text-white {
            color: #1F1E1E;
        }

        .light-mode .notification-modal-container .text-gray-400,
        .light-mode .cart-modal-container .text-gray-400,
        .light-mode .add-to-cart-modal-container .text-gray-400,
        .light-mode .buy-modal-container .text-gray-400,
        .light-mode .image-gallery-modal-container .text-gray-400,
        .light-mode .fullscreen-notification-modal-container .text-gray-400 {
            color: #4B5563;
        }

        .light-mode .cart-modal-container .text-[#EDD100],
        .light-mode .add-to-cart-modal-container .text-[#EDD100],
        .light-mode .buy-modal-container .text-[#EDD100] {
            color: #D97706;
        }

        /* Adjust border colors for light mode */
        .light-mode .notification-modal-container hr,
        .light-mode .cart-modal-container hr,
        .light-mode .add-to-cart-modal-container hr,
        .light-mode .buy-modal-container hr,
        .light-mode .image-gallery-modal-container hr,
        .light-mode .fullscreen-notification-modal-container hr {
            border-color: rgba(0, 0, 0, 0.1);
        }

        .light-mode .cart-modal-container .border-white\/10,
        .light-mode .add-to-cart-modal-container .border-white\/30,
        .light-mode .buy-modal-container .border-white\/30,
        .light-mode .image-gallery-modal-container .border-white\/20,
        .light-mode .image-gallery-modal-container .border-white\/30 {
            border-color: rgba(0, 0, 0, 0.1);
        }

        /* Adjust button styles for light mode */
        .light-mode .cart-modal-container button,
        .light-mode .add-to-cart-modal-container button,
        .light-mode .buy-modal-container button,
        .light-mode .image-gallery-modal-container button,
        .light-mode .fullscreen-notification-modal-container button {
            border-color: rgba(0, 0, 0, 0.2);
        }

        .light-mode .cart-modal-container button:hover,
        .light-mode .add-to-cart-modal-container button:hover,
        .light-mode .buy-modal-container button:hover,
        .light-mode .image-gallery-modal-container button:hover,
        .light-mode .fullscreen-notification-modal-container button:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .light-mode .cart-modal-container .bg-[#047705],
        .light-mode .add-to-cart-modal-container .bg-[#047705],
        .light-mode .buy-modal-container .bg-[#047705] {
            background: #10B981;
        }

        .light-mode .cart-modal-container .bg-[#047705]:hover,
        .light-mode .add-to-cart-modal-container .bg-[#047705]:hover,
        .light-mode .buy-modal-container .bg-[#047705]:hover {
            background: #059669;
        }

        .light-mode .cart-modal-container .bg-[#047705]\/20,
        .light-mode .add-to-cart-modal-container .bg-[#047705]\/20,
        .light-mode .buy-modal-container .bg-[#047705]\/20,
        .light-mode .image-gallery-modal-container .bg-[#047705]\/20 {
            background: rgba(16, 185, 129, 0.2);
        }

        .light-mode .add-to-cart-modal-container .hover\:border-[#047705],
        .light-mode .buy-modal-container .hover\:border-[#047705] {
            border-color: #10B981;
        }

        /* Adjust specific elements */
        .light-mode .cart-modal-container #cartTotal,
        .light-mode .add-to-cart-modal-container #modalProductPrice,
        .light-mode .buy-modal-container #modalProductPriceBuy {
            color: #D97706;
        }

        .light-mode .image-gallery-modal-container #galleryLoader {
            background: rgba(255, 255, 255, 0.5);
        }

        .light-mode .image-gallery-modal-container #galleryLoader .border-t-[#047705],
        .light-mode .image-gallery-modal-container #galleryLoader .border-r-[#047705] {
            border-top-color: #10B981;
            border-right-color: #10B981;
        }

        /* Animation for cart modal */
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        
    </style>
</head>
<body>
    <!---------------------------------------------------- NAVIGATION BAR ---------------------------------------------------->
    <header>
        <nav class="fixed top-0 left-0 z-[100] w-[calc(100%-80px)] mx-10 mt-7 h-[70px] shadow-lg shadow-[#000000]/40 bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white rounded-[15px] backdrop-blur-lg">
            <div class="px-2 flex justify-between items-center h-full w-full">
                <!-- Left: Logo and Cooperatiba Text -->
                <div class="flex items-center">
                    <!-- Logo Image -->
                    <img src="/images/homepage/logo.png" alt="Logo" class="h-15 mt-1 transform hover:scale-105 transition-transform duration-300">
                    <!-- Text -->
                    <a href="{{ route('web.home') }}" class="text-lg font-semibold text-white hover:text-[#047705] transition ml-2" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705; padding-top: 5px;">
                        COOPERATIBA
                    </a>
                </div>

                <div class="flex-1 max-w-4xl mx-4">
                    <form action="{{ route('search') }}" method="GET" class="relative flex items-center">
                        @csrf
                        <input 
                            type="text" 
                            name="query"
                            placeholder="Search uniforms or about info..." 
                            class="w-[90%] py-2 pl-4 pr-2 bg-white/90 border-y border-l border-white/20 rounded-l-[10px] text-[#1F1E1E] placeholder-[#1F1E1E]/70 focus:outline-none focus:ring-1 focus:ring-[#047705]/50 focus:border-transparent transition-all duration-300"
                            style="font-family: 'Inria Sans', sans-serif; font-weight: 300;"
                            value="{{ request('query') ?? '' }}"
                        >
                        <button type="submit" class="w-[10%] h-full py-2 px-4 bg-[#047705] hover:bg-[#036504] text-white rounded-r-[10px] border border-[#047705] transition-colors duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Right: Navigation Links -->
                <div class="flex items-center space-x-1 mr-5">
                    <!-- Items Shortcut -->
                    <a href="{{ route('web.items') }}" class="nav-link text-white item-button" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 glowing-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>         
                    </a>

                    @auth
                        @if(auth()->user()->role === 'student')
                            <!-- Cart Icon Link (styled like notification bell) -->
                            <a href="#" onclick="openCartModal()" id="cartTrigger" class="nav-link nav-link-cart text-white relative" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @php
                                    $cartItems = \App\Models\CartsModel::with('uniform')->where('user_id', auth()->id())->get();
                                    $cartItemCount = $cartItems->sum('quantity');
                                @endphp

                                    <span id="cartCounter" class="absolute -top-0 -right-0 bg-yellow-400 text-black text-[10px] rounded-full h-4 w-4 flex items-center justify-center">
                                        {{ $cartItemCount }}
                                    </span>
                            </a>
                            <!-- Chat Link -->
                            <a href="{{ route('student.chat') }}" class="nav-link nav-link-chat text-white relative" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                    @if(isset($chatCount) && $chatCount > 0)                                    
                                    <span class="absolute -top-0 -right-0 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center">
                                        {{ $chatCount }}
                                    </span>
                                @endif
                            </a>
                            <!-- Notification Link -->
                            <a href="#" id="notificationTrigger" class="nav-link nav-link-notification text-white relative" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 
                                        0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 
                                        1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if(isset($notificationCount) && $notificationCount > 0)
                                    <span id="notificationBadge" class="absolute -top-0 -right-0 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center">
                                        {{ $notificationCount }}
                                    </span>

                                @endif
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('web.about') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                        About
                    </a>
                 
                    @auth
                        @if(auth()->user()->role === 'student')
                        <a href="{{ route('web.accountsettings') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;"">My account</a>
                        

                        @endif
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">Admin</a>
                            <!-- Logout button inline with nav links -->
                            <form method="POST" action="{{ route('web.logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center text-red-600 hover:text-red-800 font-semibold nav-link"
                                        style="font-family: 'Inria Sans', sans-serif; font-weight: 500;"
                                        onclick="return confirm('Are you sure you want to logout?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                                        viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" stroke-width="2" class="mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        @endif

                    @else
                        {{-- User is NOT logged in --}}
                        <a href="{{ route('web.login') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">Login</a>
                    @endauth

                <!-- Theme Toggle Slider (Placed after My account) -->
                    <div class="theme-toggle ml-2 relative group" title="Toggle Light/Dark Mode">
                        <label class="liquid-toggle-switch">
                            <input type="checkbox" id="themeToggle" aria-label="Toggle between light and dark mode">
                            <span class="liquid-slider">
                                <span class="slider-icon">🌙</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>   
        </nav>
@include('uniforms.modals')
    </header>

    <!-- Main Content -->
    <main class="content-section"> <!-- Added padding to account for fixed nav -->
        <div>
            @yield('content')
            @yield('styles')
            @yield('scripts')
        </div>
    </main>

    <!-- ---------------------- FOOTER ---------------------- -->
    <footer class="py-10 px-6 z-10 relative" style="
        background: rgba(31, 30, 30, 0.7);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    ">
        <!-- Liquid background effect -->
        <div style="
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
        "></div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo and Brand -->
            <div>
                <div class="flex items-center mb-4">
                    <img src="/images/homepage/logo.png" alt="Logo" class="h-12 mr-2 transform hover:scale-105 transition-transform duration-300">
                    <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">COOPERATIBA</h2>
                </div>
                <p class="text-sm text-gray-300">
                    Your go-to platform for school essentials — reliable, stylish, and proudly local.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white" style="font-family: 'Inria Sans', sans-serif;">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('web.home') }}" class="text-gray-300 hover:text-[#EDD100] transition nav-link-footer">Home</a></li>
                    <li><a href="{{ route('web.about') }}" class="text-gray-300 hover:text-[#EDD100] transition nav-link-footer">About</a></li>
                    <li><a href="{{ route('web.accountsettings') }}" class="text-gray-300 hover:text-[#EDD100] transition nav-link-footer">My Account</a></li>
                    <li><a href="{{ route('web.items') }}" class="text-gray-300 hover:text-[#EDD100] transition nav-link-footer">Items</a></li>
                </ul>
            </div>

            <!-- Contact / Social -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white" style="font-family: 'Inria Sans', sans-serif;">Connect with Us</h3>
                <ul class="space-y-2">
                    <li class="text-gray-300">Email: <a href="mailto:support@cooperatiba.com" class="hover:text-[#EDD100] transition nav-link-footer">support@cooperatiba.com</a></li>
                    <li class="text-gray-300">Facebook: <a href="#" class="hover:text-[#EDD100] transition nav-link-footer">fb.com/cooperatiba</a></li>
                    <li class="text-gray-300">Phone: <span class="text-white">+63 912 345 6789</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 text-center text-sm text-gray-300 border-t border-white/30 pt-4">
            © 2025 Cooperatiba. All rights reserved.
        </div>
    </footer>

    <script>

            // Theme Toggle Logic
            document.addEventListener('DOMContentLoaded', function () {
                const themeToggle = document.getElementById('themeToggle');
                const body = document.body;
                const sliderIcon = document.querySelector('.slider-icon');

                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'light') {
                    body.classList.add('light-mode');
                    themeToggle.checked = true;
                    sliderIcon.textContent = '☀️';
                } else {
                    body.classList.remove('light-mode');
                    themeToggle.checked = false;
                    sliderIcon.textContent = '🌙';
                }

                themeToggle.addEventListener('change', function () {
                    if (this.checked) {
                        body.classList.add('light-mode');
                        sliderIcon.textContent = '☀️';
                        localStorage.setItem('theme', 'light');
                    } else {
                        body.classList.remove('light-mode');
                        sliderIcon.textContent = '🌙';
                        localStorage.setItem('theme', 'dark');
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('input[name="query"]');
                const searchForm = document.querySelector('form[action="{{ route('search') }}"]');
                
                // Debounce function to limit how often search runs
                function debounce(func, wait) {
                    let timeout;
                    return function() {
                        const context = this, args = arguments;
                        clearTimeout(timeout);
                        timeout = setTimeout(function() {
                            func.apply(context, args);
                        }, wait);
                    };
                }
                
                // Live search functionality
                searchInput.addEventListener('input', debounce(function() {
                    const query = this.value.trim();
                    
                    if(query.length > 2) { // Only search if at least 3 characters
                        fetch(`/search?query=${encodeURIComponent(query)}`)
                            .then(response => response.text())
                            .then(html => {
                                // You'll need to create a container to show live results
                                document.getElementById('live-search-results').innerHTML = html;
                            });
                    }
                }, 300));
                
                // Prevent form submission if using live search
                searchForm.addEventListener('submit', function(e) {
                    if(searchInput.value.trim().length < 1) {
                        e.preventDefault();
                    }
                });
            });
                
            document.getElementById('checkoutButton').addEventListener('click', function (e) {
                e.preventDefault();

                // Get all checked items
                const selectedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Please select at least one item to checkout.');
                    return;
                }

                // Collect selected items' details
                const selectedItems = Array.from(selectedCheckboxes).map(checkbox => {
                    const cartItem = checkbox.closest('.cart-item');
                    return {
                        uniformId: cartItem.dataset.uniformId,
                        size: cartItem.dataset.size,
                        quantity: cartItem.dataset.quantity
                    };
                });

                // Create form dynamically to submit multiple items
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('web.payment') }}";

                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }

                // Add from_cart parameter
                const fromCartInput = document.createElement('input');
                fromCartInput.type = 'hidden';
                fromCartInput.name = 'from_cart';
                fromCartInput.value = '1';
                form.appendChild(fromCartInput);

                // Add selected items as JSON or individual inputs
                selectedItems.forEach((item, index) => {
                    const uniformIdInput = document.createElement('input');
                    uniformIdInput.type = 'hidden';
                    uniformIdInput.name = `items[${index}][uniform_id]`;
                    uniformIdInput.value = item.uniformId;
                    form.appendChild(uniformIdInput);

                    const sizeInput = document.createElement('input');
                    sizeInput.type = 'hidden';
                    sizeInput.name = `items[${index}][size]`;
                    sizeInput.value = item.size;
                    form.appendChild(sizeInput);

                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = `items[${index}][quantity]`;
                    quantityInput.value = item.quantity;
                    form.appendChild(quantityInput);
                });

                // Append form to body and submit
                document.body.appendChild(form);
                form.submit();
            });
            function closeCartModal() {
                document.getElementById('cartModal').classList.add('hidden');
            }

            const cartContainer = document.querySelector('#cartModal .cart-items');
            const cartItemCount = document.getElementById('cartItemCount');
            const cartSubtotal = document.getElementById('cartSubtotal');

            const cartTotal = document.getElementById('cartTotal');

            function populateCart(items) {
                cartContainer.innerHTML = '';
                let subtotal = 0;

                items.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;

                    const cartItem = document.createElement('div');
                    cartItem.className = 'flex items-center justify-between py-3 border-b border-white/10 hover:bg-white/5 transition-colors';
                    cartItem.innerHTML = `
                        <div class="flex items-center space-x-3 cart-item" 
                            data-cart-id="${item.id}" 
                            data-uniform-id="${item.uniform_id}"
                            data-size="${item.size}" 
                            data-quantity="${item.quantity}">
                            
                            <input type="checkbox" 
                                class="h-5 w-5 rounded border-gray-300 text-[#047705] focus:ring-[#047705] cart-checkbox" 
                                data-cart-id="${item.id}">

                            <div class="flex items-center space-x-4">
                                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-white font-medium">${item.name}</h4>
                                    <p class="text-sm text-gray-400">₱${item.price.toFixed(2)} × ${item.quantity}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <span class="text-white font-medium">₱${itemTotal.toFixed(2)}</span>
                            <button class="text-red-400 hover:text-red-300" onclick="removeCartItem(${item.id})" data-cart-id="${item.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    `;
                    cartContainer.appendChild(cartItem);
                });

                cartItemCount.textContent = `(${items.length} item${items.length !== 1 ? 's' : ''})`;
                cartSubtotal.textContent = `₱${subtotal.toFixed(2)}`;

                cartTotal.textContent = `₱${subtotal.toFixed(2)}`; // You can add shipping later
            }
            
            async function openCartModal() {
                try {
                    const response = await fetch("{{ route('web.cart.items') }}");
                    const items = await response.json();

                    const formattedItems = items.map(item => {
                        if (!item.uniform) return null;
                        return {
                            id: item.id,
                            name: item.uniform.name,
                            price: parseFloat(item.uniform.price),
                            quantity: item.quantity,
                            image: item.uniform.image_url,
                            uniform_id: item.uniform?.uniform_id ?? 'MISSING',
                            size: item.size ?? 'N/A'
                        };
                    });

                    // Use populateCart to render items
                    populateCart(formattedItems);

                    // Update cart counter
                    const totalCount = formattedItems.reduce((sum, item) => sum + item.quantity, 0);
                    document.getElementById('cartCounter').textContent = totalCount;

                    // Show modal
                    document.getElementById('cartModal').classList.remove('hidden');
                } catch (error) {
                    console.error("Failed to load cart items:", error);
                }
            }
            
            async function removeCartItem(cartId) {
                if (cartId === undefined || cartId === null || isNaN(cartId)) {
                    alert("Invalid cart item ID");
                    return;
                }
                if (!confirm("Remove this item from your cart?")) return;

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    if (!csrfToken) {
                        throw new Error('CSRF token not found');
                    }
                    const response = await fetch(`/cart/remove/${cartId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    });
                    if (response.ok) {
                        openCartModal();
                    } else {
                        const errorData = await response.json();
                        alert(`Failed to remove item: ${errorData.message || 'Unknown error'}`);
                    }
                } catch (error) {
                    console.error("Failed to remove cart item:", error);
                    alert("An error occurred while removing the item: " + error.message);
                }
            }

            function selectAllItems() {
                const checkboxes = document.querySelectorAll('#cartModal .cart-items input[type="checkbox"]');
                if (checkboxes.length === 0) {
                    alert('No items in the cart to select.');
                    return;
                }
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateCartSummary();
            }
            async function removeSelected() {
                const checkboxes = document.querySelectorAll('#cartModal .cart-items input[type="checkbox"]:checked');
                if (checkboxes.length === 0) {
                    alert('No items selected');
                    return;
                }
                if (!confirm('Remove selected items from your cart?')) return;

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    if (!csrfToken) {
                        throw new Error('CSRF token not found');
                    }

                    const cartIds = Array.from(checkboxes).map(cb => cb.dataset.cartId);

                    await Promise.all(cartIds.map(cartId =>
                        fetch(`/cart/remove/${cartId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken }
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error(`Failed to remove item with ID ${cartId}`);
                            }
                            return response;
                        })
                    ));

                    openCartModal(); // Refresh the cart view
                } catch (error) {
                    console.error('Error removing selected items:', error);
                    alert('An error occurred while removing items: ' + error.message);
                }
            }

        function openNotificationModal(type, title, content, time) {
            const modal = document.getElementById('notificationModal');

            // Set content
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalContent').textContent = content;
            document.getElementById('modalTime').textContent = time;

            // Get icon container
            const iconContainer = document.getElementById('iconContainer');
            iconContainer.innerHTML = ''; // Clear previous icon

            // Set icon based on type
            let iconHtml = '';
            if (type === 'ORDER UPDATE') {
                iconHtml = `
                    <div class="bg-[#EDD100]/20 p-2 rounded-lg backdrop-blur-sm border border-[#EDD100]/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#EDD100]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>`;
            } else if (type === 'chat') {
                iconHtml = `
                    <div class="bg-[#047705]/20 p-2 rounded-lg backdrop-blur-sm border border-[#047705]/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>`;
            } else if (type === 'promo') {
                iconHtml = `
                    <div class="bg-[#8B5CF6]/20 p-2 rounded-lg backdrop-blur-sm border border-[#8B5CF6]/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#8B5CF6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </div>`;
            }

            iconContainer.innerHTML = iconHtml;

            // Show the modal
            modal.classList.remove('hidden');

            // Close modal logic
            document.getElementById('modalCloseBtn').onclick = function () {
                modal.classList.add('hidden');
                iconContainer.innerHTML = ''; // Clear icon
            };
        }
        document.addEventListener("DOMContentLoaded", () => {
            // --- Highlight active nav link ---
            const currentPath = window.location.pathname.replace(/\/$/, "");
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (!link.href || link.href === '#' || link.href.endsWith('#')) {
                    return;
                }

                try {
                    const linkPath = new URL(link.href).pathname.replace(/\/$/, "");
                    if (linkPath === currentPath) {
                        link.classList.add('active');
                    }
                } catch (e) {
                    console.error("Error processing link:", link.href, e);
                }
            });

            // --- Footer nav-link hover effect ---
            const footerLinks = document.querySelectorAll('.nav-link-footer');
            footerLinks.forEach(link => {
                link.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                    this.style.textShadow = '0 2px 4px rgba(237, 209, 0, 0.4)';
                });

                link.addEventListener('mouseleave', function () {
                    this.style.transform = '';
                    this.style.textShadow = '';
                });
            });

            // --- Notification modal functionality ---
            const modal = document.getElementById('fullscreenNotificationModal');
            const closeBtn = document.getElementById('fullscreenModalClose');
            const notificationTrigger = document.getElementById('notificationTrigger');
            const modalContent = document.getElementById('fullscreen-notification-content');
            const notificationCountBadge = document.querySelector('.nav-link .bg-red-500');

            async function loadModalNotifications() {
                const notifications = await fetchNotifications();
                renderNotifications(notifications, modalContent);
                updateNotificationCount(notifications.length);
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
                    return data.status === 'success' ? data.data : [];
                } catch (error) {
                    console.error('Error fetching notifications:', error);
                    return [];
                }
            }

            function renderNotifications(notifications, container) {
                container.innerHTML = '';

                if (notifications.length === 0) {
                    container.innerHTML = '<p class="text-gray-400">No notifications available.</p>';
                    return;
                }

                notifications.forEach(notification => {
                    const notificationHtml = `
                        <div class="relative group mb-3">
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

            function updateNotificationCount(count) {
                    if (notificationCountBadge) {
                        notificationCountBadge.textContent = count;
                        notificationCountBadge.style.display = count > 0 ? 'flex' : 'none';
                    }
                }

                if (notificationTrigger) {
                    notificationTrigger.addEventListener('click', function () {
                        modal.classList.remove('hidden');
                        loadModalNotifications(); // Load notifications into modal

                        // ✅ Mark notifications as read when the notification modal opens
                        fetch('/notifications/mark-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('[✓] Notifications marked as read');
                            const badge = document.getElementById('notificationBadge');
                            if (badge) badge.style.display = 'none';
                        })
                        .catch(error => {
                            console.error('[x] Error marking notifications as read:', error);
                        });
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        modal.classList.add('hidden');
                    });
                }
            });
    </script>

</body>
</html>