@extends('adminslayout')

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
        /* Updated Table Styles */
        .liquid-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: rgba(31, 30, 30, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
    }
    
    .liquid-table thead {
        background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
    }
    
    .liquid-table th {
        padding: 12px 16px;
        text-align: left;
        color: white;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .liquid-table td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.9);
    }
    
    .liquid-table tr:last-child td {
        border-bottom: none;
    }
    
    .liquid-table tr:hover td {
        background: rgba(4, 119, 5, 0.1);
    }
    
    /* Updated Modal Styles */
    .liquid-modal {
        background: rgba(31, 30, 30, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .liquid-modal::before {
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
        border-radius: 20px;
    }
    
    .liquid-modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
    }
    
    .liquid-modal-title {
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
        text-shadow: -1px 1px 0px #047705;
    }
    
    .liquid-modal-body {
        padding: 20px;
    }
    
    .liquid-modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    /* Form Input Styles */
    .liquid-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 14px;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .liquid-input:focus {
        outline: none;
        border-color: #047705;
        box-shadow: 0 0 0 2px rgba(4, 119, 5, 0.3);
        background: rgba(255, 255, 255, 0.08);
    }
    
    .liquid-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    
    .liquid-label {
        display: block;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
    }
    
    /* Button Styles */
    .modal-liquid-btn {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .modal-liquid-btn-primary {
        background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
    }
    
    .modal-liquid-btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .modal-liquid-btn-danger {
        background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(211, 47, 47, 0.4);
    }
    
    .modal-liquid-btn:hover {
        transform: translateY(-2px);
    }
    
    .modal-liquid-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.6s ease;
    }
    
    .modal-liquid-btn:hover::before {
        left: 100%;
    }
    
    /* Image Preview */
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
    
    /* Variant Badges */
    .variant-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 5px;
        margin-bottom: 5px;
        background: rgba(4, 119, 5, 0.2);
        color: #71C862;
        border: 1px solid rgba(113, 200, 98, 0.3);
    }
    
    /* Form Group */
    .form-group {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('admin-content')
<!-- Updated Table in your HTML -->
<div class="overflow-x-auto">
    <div class="h-[750px]">
        <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm overflow-hidden flex flex-col">
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
            <table class="liquid-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Total Stock</th>
                        <th>New Stock</th>
                        <th>Sizes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uniforms as $uniform)
                    <tr>
                        <td>
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $uniform->image_url }}" alt="{{ $uniform->name }}">
                            </div>
                        </td>
                        <td>{{ $uniform->uniform_id }}</td>
                        <td class="font-medium">{{ $uniform->name }}</td>
                        <td>₱{{ number_format($uniform->price, 2) }}</td>
                        <td>{{ $uniform->stock_quantity }}</td>
                        <td>{{ $uniform->new_stock }}</td>
                        <td>
                            @if($uniform->size)
                                @foreach(explode(',', $uniform->size) as $size)
                                    <span class="variant-badge">{{ $size }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="font-medium">
                        <button
                            onclick="openEditProductModal(
                                '{{ $uniform->uniform_id }}',
                                '{{ addslashes($uniform->name) }}',
                                '{{ $uniform->price }}',
                                '{{ $uniform->stock_quantity}}',
                                '{{ $uniform->new_stock }}',
                                `{{ addslashes($uniform->description) }}`,
                                '{{ $uniform->image_url }}',
                                '{{ $uniform->size }}'
                            )"
                            class="text-indigo-300 hover:text-indigo-100 admin-action-btn mr-3">
                            Edit
                        </button>
                            <button onclick="confirmDelete('{{ $uniform->uniform_id }}')" class="text-red-300 hover:text-red-100 admin-action-btn">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>      
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 overflow-y-auto z-[1000]">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black opacity-70"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom liquid-modal text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="addProductForm" action="{{ route('admin.uniforms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="liquid-modal-header">
                    <h3 class="liquid-modal-title">Add New Product</h3>
                    <button type="button" onclick="closeAddProductModal()" class="absolute top-2 right-4 text-white text-xl font-bold hover:text-red-500">&times;</button>
                </div>
                <div class="liquid-modal-body">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6 form-group">
                            <label for="name" class="liquid-label">Product Name</label>
                            <input type="text" name="name" id="name" class="liquid-input" required>
                        </div>
                        
                        <div class="sm:col-span-3 form-group">
                            <label for="price" class="liquid-label">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="liquid-input" required>
                        </div>
                        
                        <div class="sm:col-span-3 form-group">
                            <label for="stock_quantity" class="liquid-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="liquid-input" readonly>
                        </div>

                        <div class="sm:col-span-3 form-group">
                            <label for="new_stock" class="liquid-label">New Stock</label>
                            <input type="number" name="new_stock" id="new_stock" class="liquid-input">
                        </div>

                        
                        <div class="sm:col-span-6 form-group">
                            <label for="size" class="liquid-label">Available Sizes (comma separated)</label>
                            <input type="text" name="size" id="size" class="liquid-input" placeholder="S,M,L,XL" required>
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label for="description" class="liquid-label">Description</label>
                            <textarea name="description" id="description" rows="3" class="liquid-input"></textarea>
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label for="image" class="liquid-label">Product Image</label>
                            <input type="file" name="image" id="image" class="liquid-input" accept="image/*" required>
                            <div class="image-preview-container mt-2" id="imagePreviewContainer">
                                <!-- Preview will be shown here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" onclick="closeAddProductModal()" class="modal-liquid-btn modal-liquid-btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="modal-liquid-btn modal-liquid-btn-primary">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Edit Product Modal -->
<div id="editProductModal" class="hidden fixed inset-0 overflow-y-auto z-[1000]">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black opacity-70"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom liquid-modal text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="editProductForm" method="POST" action="{{ route('admin.uniforms.update', ['uniform_id' => $uniform->uniform_id]) }}">
                @csrf
                <div class="liquid-modal-header">
                    <h3 class="liquid-modal-title">Edit Product</h3>
                    <button type="button" onclick="closeEditProductModal()" class="absolute top-2 right-4 text-white text-xl font-bold hover:text-red-500">&times;</button>
                </div>
                <div class="liquid-modal-body">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6 form-group">
                            <label for="edit_name" class="liquid-label">Product Name</label>
                            <input type="text" name="name" id="edit_name" class="liquid-input" required>
                        </div>
                        
                        <div class="sm:col-span-3 form-group">
                            <label for="edit_price" class="liquid-label">Price</label>
                            <input type="number" step="0.01" name="price" id="edit_price" class="liquid-input" required>
                        </div>
                        
                        <div class="sm:col-span-3 form-group">
                            <label for="edit_stock_quantity" class="liquid-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="edit_stock_quantity" class="liquid-input" readonly>
                        </div>

                        <div class="sm:col-span-3 form-group">
                            <label for="edit_new_stock" class="liquid-label">New Stock</label>
                            <input type="number" name="new_stock" id="edit_new_stock" class="liquid-input">
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label for="edit_sizes" class="liquid-label">Available Sizes (comma separated)</label>
                            <input type="text" name="size" id="edit_sizes" class="liquid-input" placeholder="S,M,L,XL" required>
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label for="edit_description" class="liquid-label">Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="liquid-input"></textarea>
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label class="liquid-label">Current Image</label>
                            <img id="current_image_preview" src="" alt="Current Image" class="h-32 w-32 object-contain mt-2 rounded-lg border border-green-500">
                        </div>
                        
                        <div class="sm:col-span-6 form-group">
                            <label for="edit_image" class="liquid-label">Change Image (optional)</label>
                            <input type="file" name="image" id="edit_image" class="liquid-input" accept="image/*">
                            <div class="image-preview-container mt-2" id="editImagePreviewContainer">
                                <!-- Preview will be shown here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" onclick="closeEditProductModal()" class="modal-liquid-btn modal-liquid-btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="modal-liquid-btn modal-liquid-btn-primary">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Updated Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="hidden fixed inset-0 overflow-y-auto z-[1000]">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black opacity-70"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom liquid-modal text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="liquid-modal-header flex items-center">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900 bg-opacity-30 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="liquid-modal-title">Delete Product</h3>
                </div>
            </div>
            <div class="liquid-modal-body">
                <p class="text-gray-300">Are you sure you want to delete this product? This action cannot be undone.</p>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" onclick="closeDeleteConfirmationModal()" class="modal-liquid-btn modal-liquid-btn-secondary">
                    Cancel
                </button>
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-liquid-btn modal-liquid-btn-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Stock calculation logic ---
        const editNewStockInput = document.getElementById('edit_new_stock');
        const editStockQuantityInput = document.getElementById('edit_stock_quantity');
        let currentStock = 0;

        window.setEditInitialStock = function (value) {
            currentStock = parseInt(value) || 0;
            editStockQuantityInput.value = currentStock; // set only current stock from DB
        };

        editNewStockInput.addEventListener('input', () => {
            const newStock = parseInt(editNewStockInput.value) || 0;
            editStockQuantityInput.value = currentStock + newStock;
        });

        // --- Add product stock logic ---
        const newStockInput = document.getElementById('new_stock');
        const stockQuantityInput = document.getElementById('stock_quantity');
        let initialStock = 0;

        window.setInitialStock = function (value) {
            initialStock = parseInt(value) || 0;
            stockQuantityInput.value = initialStock;
        };

        newStockInput.addEventListener('input', () => {
            const newStock = parseInt(newStockInput.value) || 0;
            stockQuantityInput.value = initialStock + newStock;
        });

        // --- Image Preview (Add) ---
        document.getElementById('image').addEventListener('change', function () {
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = '';
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // --- Image Preview (Edit) ---
        document.getElementById('edit_image').addEventListener('change', function () {
            const previewContainer = document.getElementById('editImagePreviewContainer');
            previewContainer.innerHTML = '';
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // --- Modal Controls ---
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.remove('hidden');
    }

    function closeAddProductModal() {
        document.getElementById('addProductModal').classList.add('hidden');
        document.getElementById('imagePreviewContainer').innerHTML = '';
        document.getElementById('addProductForm').reset();
    }

    function openEditProductModal(uniform_id, name, price, stock, newStock, description, imageUrl, size) {
        const form = document.getElementById('editProductForm');
        form.action = `/uniforms/update/${uniform_id}`;

        // Reset new stock and set actual values
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_new_stock').value = ''; // Always start empty
        document.getElementById('edit_stock_quantity').value = stock; // Actual stock, no calculation yet
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_sizes').value = size;
        document.getElementById('current_image_preview').src = imageUrl;
        document.getElementById('editImagePreviewContainer').innerHTML = '';

        // Set the current stock for JS-side calculation
        setEditInitialStock(stock);

        document.getElementById('editProductModal').classList.remove('hidden');
    }

    function closeEditProductModal() {
        document.getElementById('editProductModal').classList.add('hidden');
        document.getElementById('editProductForm').reset();
        document.getElementById('editImagePreviewContainer').innerHTML = '';
    }

    function confirmDelete(id) {
        const form = document.getElementById('deleteProductForm');
        form.action = "{{ route('admin.uniforms.destroy', ':id') }}".replace(':id', id);
        document.getElementById('deleteConfirmationModal').classList.remove('hidden');
    }

    function closeDeleteConfirmationModal() {
        document.getElementById('deleteConfirmationModal').classList.add('hidden');
    }
</script>

@endsection