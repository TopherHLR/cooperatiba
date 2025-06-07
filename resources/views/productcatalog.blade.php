@extends('layouts.sharedlayout')

@section('title', 'Product Catalog')

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

    /* Admin specific styles */
    .admin-action-btn {
        transition: all 0.2s ease;
    }
    
    .admin-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #047705;
    }
    
    .variant-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 5px;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="content-section min-h-screen">
    <div class="content-overlay min-h-screen">
        @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 2500)" 
                x-show="show"
                x-transition
                class="fixed top-20 left-1/2 transform -translate-x-1/2 w-[90%] z-50 bg-green-100 border border-green-400 text-green-700 rounded p-4 shadow-lg"
            >
                {{ session('success') }}
            </div>
        @endif
        
        <div class="flex mx-10 justify-center gap-10">
            <!-- Main Container -->
            <div class="w-full mt-40">
                <div class="liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Add Product Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">PRODUCT CATALOG</h2>
                        <button onclick="openAddProductModal()" class="liquid-btn flex items-center space-x-2 px-4 py-2 rounded-[20px] text-white hover:bg-[#036603] transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Add Product</span>
                        </button>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Variants</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($uniforms as $uniform)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $uniform->image_url }}" alt="{{ $uniform->name }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $uniform->uniform_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $uniform->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($uniform->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $uniform->stock_quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($uniform->sizes)
                                            @foreach(explode(',', $uniform->sizes) as $size)
                                                <span class="variant-badge bg-green-100 text-green-800">{{ $size }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openEditProductModal(
                                            '{{ $uniform->uniform_id }}',
                                            '{{ $uniform->name }}',
                                            '{{ $uniform->price }}',
                                            '{{ $uniform->stock_quantity }}',
                                            '{{ $uniform->description }}',
                                            '{{ $uniform->image_url }}',
                                            '{{ $uniform->sizes }}'
                                        )" class="text-indigo-600 hover:text-indigo-900 admin-action-btn mr-3">
                                            Edit
                                        </button>
                                        <button onclick="confirmDelete('{{ $uniform->uniform_id }}')" class="text-red-600 hover:text-red-900 admin-action-btn">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $uniforms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="addProductForm" action="{{ route('uniforms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Product</h3>
                            <div class="mt-2 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" id="name" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="number" step="0.01" name="price" id="price" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="sizes" class="block text-sm font-medium text-gray-700">Available Sizes (comma separated)</label>
                                    <input type="text" name="sizes" id="sizes" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="S,M,L,XL" required>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                                    <input type="file" name="image" id="image" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" accept="image/*" required>
                                    <div class="image-preview-container mt-2" id="imagePreviewContainer">
                                        <!-- Preview will be shown here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Product
                    </button>
                    <button type="button" onclick="closeAddProductModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="hidden fixed inset-0 overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Product</h3>
                            <div class="mt-2 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" id="edit_name" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="edit_price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="number" step="0.01" name="price" id="edit_price" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="edit_stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" id="edit_stock_quantity" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="edit_sizes" class="block text-sm font-medium text-gray-700">Available Sizes (comma separated)</label>
                                    <input type="text" name="sizes" id="edit_sizes" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="S,M,L,XL" required>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="edit_description" rows="3" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Current Image</label>
                                    <img id="current_image_preview" src="" alt="Current Image" class="h-32 w-32 object-contain mt-2">
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="edit_image" class="block text-sm font-medium text-gray-700">Change Image (optional)</label>
                                    <input type="file" name="image" id="edit_image" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" accept="image/*">
                                    <div class="image-preview-container mt-2" id="editImagePreviewContainer">
                                        <!-- Preview will be shown here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Product
                    </button>
                    <button type="button" onclick="closeEditProductModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="hidden fixed inset-0 overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Product</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete this product? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="closeDeleteConfirmationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

<!-- JavaScript -->
<script>
    // Image preview for add product form
    document.getElementById('image').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';
                previewContainer.appendChild(img);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Image preview for edit product form
    document.getElementById('edit_image').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('editImagePreviewContainer');
        previewContainer.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';
                previewContainer.appendChild(img);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Modal control functions
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.remove('hidden');
    }
    
    function closeAddProductModal() {
        document.getElementById('addProductModal').classList.add('hidden');
        document.getElementById('imagePreviewContainer').innerHTML = '';
        document.getElementById('addProductForm').reset();
    }
    
    function openEditProductModal(id, name, price, stock, description, imageUrl, sizes) {
        // Set form action
        const form = document.getElementById('editProductForm');
        form.action = `/admin/uniforms/${id}`;
        
        // Populate form fields
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock_quantity').value = stock;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_sizes').value = sizes;
        document.getElementById('current_image_preview').src = imageUrl;
        
        // Clear any previous image preview
        document.getElementById('editImagePreviewContainer').innerHTML = '';
        
        // Show modal
        document.getElementById('editProductModal').classList.remove('hidden');
    }
    
    function closeEditProductModal() {
        document.getElementById('editProductModal').classList.add('hidden');
    }
    
    function confirmDelete(id) {
        // Set form action
        const form = document.getElementById('deleteProductForm');
        form.action = `/admin/uniforms/${id}`;
        
        // Show modal
        document.getElementById('deleteConfirmationModal').classList.remove('hidden');
    }
    
    function closeDeleteConfirmationModal() {
        document.getElementById('deleteConfirmationModal').classList.add('hidden');
    }
</script>
@endsection