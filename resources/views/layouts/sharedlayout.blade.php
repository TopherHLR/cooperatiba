<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cooperatiba')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body>
    <!---------------------------------------------------- NAVIGATION BAR ---------------------------------------------------->
    <header>
        <nav class="fixed top-0 left-0 z-[100] w-[calc(100%-80px)] mx-10 mt-7 h-[70px] bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/10 border-[.5px] border-white rounded-[44px]">
            <div class="px-2 flex justify-between items-center h-full w-full">
                <!-- Left: Logo and Cooperatiba Text -->
                <div class="flex items-center">
                    <!-- Logo Image -->
                    <img src="/images/homepage/logo.png" alt="Logo" class="h-15 mt-1">
                    <!-- Text -->
                    <a href="#" class="text-lg font-semibold text-white hover:text-[#047705] transition" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705; padding-top: 5px;">
                        COOPERATIBA
                    </a>
                </div>

                <!-- Right: Navigation Links -->
                <div class="flex items-center space-x-4 mr-5">
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Home
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Orders
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        About
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Account
                    </a>
                </div>
            </div>   
        </nav>
    </header>

    <!-- Main Content -->
    <main > <!-- Added padding to account for fixed nav -->
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>