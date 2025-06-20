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
    @endif

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
                        class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                        placeholder="••••••••"
                        required
                    >
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
                        class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                        placeholder="••••••••"
                        required
                    >
                </div>
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