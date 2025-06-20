<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Cooperatiba</title>
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
        
        .liquid-error-alert, .liquid-success-alert {
            transition: opacity 0.3s ease;
            animation: slideIn 0.3s ease forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .content-section {
            background-image: url('/images/cooperatibaitems/2ndBG.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="w-full py-4 px-10 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="/images/homepage/logo.png" alt="Logo" class="h-12">
            <a href="{{ route('web.home') }}" class="text-lg font-semibold text-white ml-2" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                COOPERATIBA
            </a>
        </div>

        <!-- Links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('web.home') }}" class="text-white hover:text-[#EDD100] transition">Home</a>
            <a href="{{ route('web.about') }}" class="text-white hover:text-[#EDD100] transition">About</a>
            <a href="{{ route('web.items') }}" class="text-white hover:text-[#EDD100] transition">Items</a>
        </div>
    </nav>
    
    <div class="content-section min-h-screen">
        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center p-4 mt-44">
            <div class="w-full max-w-md mx-auto">
                @if (session('status'))
                    <div class="liquid-success-alert mb-6">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-green-900/70 to-green-800/70 border border-green-700/50 backdrop-blur-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-green-100">{{ session('status') }}</span>
                            </div>
                            <button type="button" class="text-green-300 hover:text-white" onclick="this.parentElement.parentElement.remove()">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <script>
                        // Auto-dismiss success alert after 5 seconds
                        document.addEventListener('DOMContentLoaded', function() {
                            const successAlert = document.querySelector('.liquid-success-alert');
                            if (successAlert) {
                                setTimeout(() => {
                                    successAlert.style.opacity = '0';
                                    setTimeout(() => successAlert.remove(), 300);
                                }, 5000);
                            }
                        });
                    </script>
                @endif

                @if ($errors->has('email') || $errors->has('password'))
                    <div class="liquid-error-alert mb-6">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-red-900/70 to-red-800/70 border border-red-700/50 backdrop-blur-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-red-100">{{ $errors->first('email') ?: $errors->first('password') }}</span>
                            </div>
                            <button type="button" class="text-red-300 hover:text-white" onclick="this.parentElement.parentElement.remove()">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <script>
                        // Auto-dismiss error alert after 5 seconds
                        document.addEventListener('DOMContentLoaded', function() {
                            const errorAlert = document.querySelector('.liquid-error-alert');
                            if (errorAlert) {
                                setTimeout(() => {
                                    errorAlert.style.opacity = '0';
                                    setTimeout(() => errorAlert.remove(), 300);
                                }, 5000);
                            }
                        });
                    </script>
                @endif

                <!-- Reset Password Card -->
                <div class="liquid-card p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-white mb-2">Set New Password</h2>
                        <p class="text-gray-300">Enter your new password below</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email Input -->
                        <div class="mb-6">
                            <label for="email" class="block text-white mb-2">Email Address</label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email"
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    placeholder="e.g. user@cooperatiba.com"
                                    required
                                    value="{{ old('email') }}"
                                >
                            </div>
                            @error('email')
                                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <label for="password" class="block text-white mb-2">New Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    class="w-full px-4 py-3 pr-10 rounded-lg liquid-input text-white focus:outline-none" 
                                    placeholder="••••••••"
                                    required
                                >
                                <button 
                                    type="button" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#047705] transition"
                                    onclick="togglePasswordVisibility('password')"
                                    aria-label="Toggle password visibility"
                                >
                                    <svg id="showPasswordIcon_password" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10z" clip-rule="evenodd" />
                                    </svg>
                                    <svg id="hidePasswordIcon_password" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation Input -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-white mb-2">Confirm Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    class="w-full px-4 py-3 pr-10 rounded-lg liquid-input text-white focus:outline-none" 
                                    placeholder="••••••••"
                                    required
                                >
                                <button 
                                    type="button" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#047705] transition"
                                    onclick="togglePasswordVisibility('password_confirmation')"
                                    aria-label="Toggle password confirmation visibility"
                                >
                                    <svg id="showPasswordIcon_password_confirmation" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10z" clip-rule="evenodd" />
                                    </svg>
                                    <svg id="hidePasswordIcon_password_confirmation" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button class="w-full py-3 px-4 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                            Reset Password
                        </button>

                        <!-- Back to Login Link -->
                        <div class="text-center mt-4">
                            <p class="text-gray-400">Back to <a href="{{ route('web.login') }}" class="text-[#047705] hover:underline">Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-400 text-sm">
        <p>© 2023 Cooperatiba. All rights reserved.</p>
    </footer>
</body>
</html>
<script>
    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const showIcon = document.getElementById(`showPasswordIcon_${fieldId}`);
        const hideIcon = document.getElementById(`hidePasswordIcon_${fieldId}`);
        
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