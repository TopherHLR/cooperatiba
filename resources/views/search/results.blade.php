@extends('layouts.sharedlayout')

@section('content')
<div class="content-section flex  mx-10 justify-center min-h-full">
    <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] w-[100%] mt-32 mb-10 h-full backdrop-blur-sm flex flex-col">
        
        <!-- Main Content Container -->
        <div class=" mb-10 liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 mx-10 mt-10 backdrop-blur-sm">
            
            <!-- Title Section -->
            <div class="flex items-center mb-4">
                <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                    Search Results for "{{ $query }}"
                </h2>
            </div>
            <hr class="border-[.5px] border-white mb-6 -mx-6">
            
            @if($uniforms->count() > 0 || $aboutMatches->count() > 0 || $missionMatches->count() > 0 || $teamMatches->count() > 0)
                
            <!-- Uniform Results Section -->
            @if($uniforms->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-white">Uniforms</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($uniforms as $uniform)
                    <div class="bg-white rounded-[15px] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1 h-full flex flex-col">
                        <!-- Product Image -->
                        <div class="h-40 bg-gray-100/80 flex items-center justify-center p-2 group-hover:bg-gray-100 transition-colors duration-300 cursor-pointer" 
                            onclick="openImageGalleryModal('{{ $uniform->name }}')">
                            <img src="{{ $uniform->image_url }}" alt="{{ $uniform->name }}" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                        </div>
                        
                        <!-- Product Info -->   
                        <div class="p-3 bg-[#008E01] text-white group-hover:bg-[#007a01] transition-colors duration-300 flex-grow flex flex-col">
                            <h3 class="font-bold text-sm mb-1 line-clamp-2">{{ $uniform->name }}</h3>
                            <div class="text-xs text-gray-200 mb-2">
                                <span>Size: {{ $uniform->size }}</span>
                            </div>
                            <div class="mt-auto">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium">₱{{ number_format($uniform->price, 2) }}</span>
                                    <div class="flex space-x-1">
                                        <button onclick="openAddToCartModal('{{ $uniform->name }}', '₱{{ number_format($uniform->price, 2) }}', '{{ $uniform->image_url }}', '{{ $uniform->uniform_id }}')" 
                                                class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button onclick="openBuyerModal('{{ $uniform->uniform_id }}', '{{ $uniform->name }}', '₱{{ number_format($uniform->price, 2) }}', '{{ $uniform->image_url }}')" 
                                                class="flex items-center justify-center bg-[#047705] hover:bg-[#036603] text-white text-xs font-medium py-1 px-2 rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
                
                <!-- About Page Results Section -->
                @if($aboutMatches->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 text-white">About Page</h2>
                    <div class="bg-[#1F1E1E]/60 rounded-lg shadow-md p-6 border border-white/10">
                        @foreach($aboutMatches as $match)
                        <p class="mb-4 text-white">{{ $match }}</p>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Mission Results Section -->
                @if($missionMatches->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 text-white">Mission</h2>
                    <div class="bg-[#1F1E1E]/60 rounded-lg shadow-md p-6 border border-white/10">
                        <ul class="space-y-4">
                            @foreach($missionMatches as $match)
                            <li class="flex items-start text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ $match }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                
                <!-- Team Results Section -->
                @if($teamMatches->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 text-white">Team Members</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($teamMatches as $member)
                        <div class="bg-[#1F1E1E]/60 rounded-lg shadow-md overflow-hidden border border-white/10 hover:shadow-xl transition-all duration-300">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-1 text-white">{{ $member['name'] }}</h3>
                                <p class="text-gray-300 mb-2">{{ $member['role'] }}</p>
                                <p class="text-gray-400 text-sm">{{ $member['bio'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
            @else
                <!-- No Results Found -->
                <div class="bg-[#1F1E1E]/60 rounded-lg shadow-md p-8 text-center border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-300">No results found for "{{ $query }}"</p>
                </div>
            @endif
            
        </div>
    </div>
</div>
<script>
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
</script>
@endsection