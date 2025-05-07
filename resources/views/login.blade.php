<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Cooperatiba</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Liquid UI Effects */
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
                rgba(4, 119, 5, 0.1) 0%,
                rgba(237, 209, 0, 0.1) 50%,
                rgba(4, 119, 5, 0.1) 100%
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
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Simplified Navigation -->
    <nav class="w-full py-4 px-10 flex justify-between items-center">
        <!-- Logo (now static) -->
        <div class="flex items-center">
            <img src="/images/homepage/logo.png" alt="Logo" class="h-12">
            <a href="{{ route('web.home') }}" class="text-lg font-semibold text-white ml-2" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                COOPERATIBA
            </a>
        </div>

        <!-- Minimal Links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('web.home') }}" class="text-white hover:text-[#EDD100] transition">Home</a>
            <a href="#" class="text-white hover:text-[#EDD100] transition">About</a>
            <a href="{{ route('web.items') }}" class="text-white hover:text-[#EDD100] transition">Items</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md mx-auto">
            <!-- Login Card -->
            <div class="liquid-card p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                    <p class="text-gray-300">Sign in to your Cooperatiba account</p>
                </div>
                
                <form>
                    <!-- Student Number Input -->
                    <div class="mb-6">
                        <label for="student_number" class="block text-white mb-2">Student Number</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="student_number" 
                                name="student_number"
                                class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                placeholder="e.g. 2023-12345"
                                pattern="[0-9]{4}-[0-9]{5}"
                                title="Please enter a valid student number (format: YYYY-XXXXX)"
                                required
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Format: YYYY-XXXXX (e.g. 2023-12345)</p>
                    </div>
                    
                    <!-- Password Input with Toggle -->
                    <div class="mb-8">
                        <label for="password" class="block text-white mb-2">Password</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                class="w-full px-4 py-3 pr-10 rounded-lg liquid-input text-white focus:outline-none" 
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#047705] transition"
                                onclick="togglePasswordVisibility()"
                                aria-label="Toggle password visibility"
                            >
                                <!-- Eye icon (hidden by default) -->
                                <svg id="showPasswordIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <!-- Eye-slash icon (hidden initially) -->
                                <svg id="hidePasswordIcon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="w-4 h-4 text-[#047705] rounded focus:ring-[#047705]">
                            <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-[#047705] hover:underline">Forgot password?</a>
                    </div>
                    
                    <!-- Login Button -->
                    <button type="submit" class="w-full py-3 px-4 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                        Sign In
                    </button>
                    
                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-400">Don't have an account? <a href="{{ route('web.register') }}" class="text-[#047705] hover:underline">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-400 text-sm">
        <p>© 2023 Cooperatiba. All rights reserved.</p>
    </footer>
</body>
</html>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const showIcon = document.getElementById('showPasswordIcon');
        const hideIcon = document.getElementById('hidePasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            hideIcon.classList.add('hidden');
            showIcon.classList.remove('hidden');
        }
    }
</script>