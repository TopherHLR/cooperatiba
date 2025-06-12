@extends('layouts.sharedlayout')

@section('title', 'Checkout')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap');
    
    body, p, ul, li, button {
        font-family: 'Jost', sans-serif;
    }
    
    .content-section {
        background-image: url('/images/cooperatibaitems/2ndBG.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    
    .payment-option:hover {
        transform: translateY(-2px);
    }
    
    .coming-soon-message {
        opacity: 0;
        height: 0;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .show-message {
        opacity: 1;
        height: auto;
        padding: 10px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')

<div class="content-section min-h-screen">
    <div class="content-overlay min-h-screen">
        <div class="flex mx-10 justify-center gap-10 pt-40">
            <!-- Checkout Container -->
            <div class="w-[100%]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/60 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 backdrop-blur-sm">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Checkout
                        </h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    <!-- Item Being Purchased -->
                    <div class="bg-[#1F1E1E]/60 rounded-xl p-4 mb-6 border border-white/10">
                        <div class="flex items-start">
                            
                        @foreach ($uniforms as $uniform)

                            <div class=" h-32 w-32 bg-gray-100 rounded-lg flex-shrink-0 mr-4 overflow-hidden">
                                <img src="{{ $uniform->image_url }}" alt="{{ $uniform->name }}" class="w-full h-full object-contain">
                            </div>
                            
                            <!-- Product Details -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                    <h3 class="text-white font-medium text-lg">{{ $uniform->name }}</h3>
                                    <p class="text-sm text-gray-400">Size: {{ $size }}</p>

                                    </div>
                                        <span class="text-white font-medium">₱{{ number_format($uniform->price, 2) }}</span>
                                    </div>                                
                                <div class="mt-4 flex justify-between items-end">
                                    <div class="flex items-center">
                                        <span class="text-white mr-2">Quantity:</span>
                                        <select name="quantity" class="..." disabled>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ $i == $quantity ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                    <div class="text-right">
                                    <p class="text-sm text-gray-400">Subtotal: ₱{{ number_format($uniform->price * $quantity, 2) }}</p>
                                    <p class="text-white font-medium mt-1">Total: ₱{{ number_format($uniform->price * $quantity, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <!-- Payment Methods -->
                    <div class="mb-6">
                        <h3 class="text-white font-medium text-lg mb-3">Payment Method</h3>
                        
                        <!-- GCash Option (Selected by default) -->
                        <div class="payment-option bg-[#047705]/30 border-2 border-[#047705] rounded-lg p-4 mb-3 cursor-pointer transition-all duration-200">
                            <div class="flex items-center">
                                <input type="radio" id="gcash" name="payment" value="gcash" checked class="h-4 w-4 text-[#047705] focus:ring-[#047705]">
                                <label for="gcash" class="ml-3 flex items-center">
                                    <img src="/images/gcash.png" alt="GCash" class="h-8 ml-2">
                                    <span class="text-white ml-3">GCash</span>
                                </label>
                            </div>
                            <p class="text-gray-300 text-sm mt-2 ml-7">Pay instantly through GCash mobile app and send the receipt to our admin's chat | COOP GCash #: 09683151166 </p>
                        </div>
                        
                        <!-- Face-to-Face Option -->
                        <div class="payment-option bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-lg p-4 mb-3 cursor-pointer transition-all duration-200 border border-white/10">
                            <div class="flex items-center">
                                <input type="radio" id="facetoface" name="payment" value="facetoface" class="h-4 w-4 text-[#047705] focus:ring-[#047705]">
                                <label for="facetoface" class="ml-3 text-white">Face-to-Face</label>
                            </div>
                            <p class="text-gray-300 text-sm mt-2 ml-7">Pay in person at the designated location</p>
                        </div>
                        
                        <!-- Other Payment Options -->
                        <div class="payment-option bg-[#1F1E1E]/60 hover:bg-[#001C00]/40 rounded-lg p-4 mb-3 cursor-pointer transition-all duration-200 border border-white/10" onclick="showComingSoon()">
                            <div class="flex items-center">
                                <input type="radio" id="other" name="payment" value="other" class="h-4 w-4 text-gray-400 focus:ring-gray-400">
                                <label for="other" class="ml-3 text-gray-400">Other Payment Methods</label>
                            </div>
                        </div>
                        
                        <!-- Coming Soon Message (Hidden by default) -->
                        <div id="comingSoonMessage" class="coming-soon-message bg-[#1F1E1E]/80 border-l-4 border-yellow-500 text-yellow-400 rounded-r">
                            <p>Other payment methods are coming soon! Please use GCash or Face-to-Face for now.</p>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <div class="text-right">
                        <form id="buyNowForm" method="POST" action="{{ route('web.items.buyNow', ['uniform_id' => $uniform->uniform_id]) }}">
                            @csrf
                            <input type="hidden" name="size" value="{{ $size }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            <input type="hidden" name="payment_method" value="gcash">
                            <button type="submit" class="bg-[#047705] hover:bg-[#036603] text-white font-medium py-2 px-6 rounded-full transition-all duration-200 shadow-md hover:shadow-lg">
                                Complete Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function showComingSoon() {
        document.getElementById('comingSoonMessage').classList.add('show-message');
        // Uncheck the other payment option after 3 seconds
        setTimeout(() => {
            document.getElementById('gcash').checked = true;
            document.getElementById('comingSoonMessage').classList.remove('show-message');
        }, 3000);
    }
</script>
@endsection
@endsection