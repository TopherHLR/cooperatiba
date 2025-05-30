<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cooperatiba')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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

                <!-- Center: Search Bar -->
                <div class="flex-1 max-w-4xl mx-4">
                    <div class="relative flex items-center">
                        <input 
                            type="text" 
                            placeholder="Search..." 
                            class="w-[90%] py-2 pl-4 pr-2 bg-white/90 border-y border-l border-white/20 rounded-l-[10px] text-[#1F1E1E] placeholder-[#1F1E1E]/70 focus:outline-none focus:ring-1 focus:ring-[#047705]/50 focus:border-transparent transition-all duration-300"
                            style="font-family: 'Inria Sans', sans-serif; font-weight: 300;"
                        >
                        <button class="w-[10%] h-full py-2 px-4 bg-[#047705] hover:bg-[#036504] text-white rounded-r-[10px] border border-[#047705] transition-colors duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="ml-2" style="font-family: 'Inria Sans', sans-serif;"> </span>
                        </button>
                    </div>
                </div>

                <!-- Right: Navigation Links -->
                <div class="flex items-center space-x-1 mr-5">
                    <a href="{{ route('web.home') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                        Home
                    </a>
                    <a href="{{ route('web.about') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">
                        About
                    </a>
                    @auth
                        <a href="{{ route('web.accountsettings') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;"">My account</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.adminslayout') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">Admin</a>
                        @endif
                    @else
                        {{-- User is NOT logged in --}}
                        <a href="{{ route('web.login') }}" class="nav-link text-white" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000;">Login</a>
                    @endauth

                </div>
            </div>   
        </nav>

    </header>

    <!-- Main Content -->
    <main> <!-- Added padding to account for fixed nav -->
        @yield('content')
        @yield('styles')
        @yield('scripts')
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
            &copy; {{ date('Y') }} Cooperatiba. All rights reserved.
        </div>
    </footer>



    <script>
    // Add active class to current page link
    document.addEventListener('DOMContentLoaded', function() {
        // Get current path without query parameters and normalize slashes
        const currentPath = window.location.pathname.replace(/\/$/, ""); // Remove trailing slash
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            // Skip links with just '#' as href
            if (link.href === '#' || link.href.endsWith('#')) {
                return;
            }
            
            try {
                // Get link path and normalize
                const linkPath = new URL(link.href).pathname.replace(/\/$/, "");
                
                // Compare normalized paths
                if (linkPath === currentPath) {
                    link.classList.add('active');
                }
            } catch (e) {
                console.error("Error processing link:", link.href, e);
            }
        });
        
        // Footer links hover effect
        const footerLinks = document.querySelectorAll('.nav-link-footer');
        footerLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.textShadow = '0 2px 4px rgba(237, 209, 0, 0.4)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.textShadow = '';
            });
        });
        });
    </script>
</body>
</html>