<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminUniformController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// routes/web.php
use App\Http\Controllers\DashboardController;

// User orders route (place first to avoid conflicts)
// Main website routes
Route::name('web.')->group(function () {
    // Public routes (direct views from root)
    Route::view('/', 'home')->name('home');
    Route::view('/home', 'home')->name('home');
        // Notifications route (protected by auth middleware)
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])
        ->name('notifications.index')
        ->middleware('auth');
        
    Route::view('/chats', 'chats')->name('chats');
    // Uniform items route - now using controller but pointing to existing items.blade.php
    Route::get('/items', [UniformController::class, 'index'])->name('items');
    Route::get('/items/{id}', [UniformController::class, 'show'])->name('items.show');
    Route::post('/buy-now', [UniformController::class, 'buyNow'])->name('items.buyNow');
    Route::get('/cart/items', [UniformController::class, 'fetchCartItems'])->name('cart.items');
    Route::post('/items/{uniform_id}/add-To-Cart', [UniformController::class, 'addToCart'])->name('items.addToCart');
    Route::delete('/cart/remove/{id}', [UniformController::class, 'remove'])->name('cart.remove');

    // Payment and order routes
    Route::post('/payment', [UniformController::class, 'showPayment'])->name('payment');
    Route::get('/payment/{uniform_id?}', [UniformController::class, 'showPayment'])->name('payment.single');

    // Authentication routes
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::post('/login', [StudentController::class, 'login'])->name('login.submit');
    Route::post('/register', [StudentController::class, 'register'])->name('register.submit');

    // Optional logout
    Route::post('/logout', [StudentController::class, 'logout'])->name('logout');
    Route::view('/orders', 'orders')->name('orders')->middleware('auth');
    
    // API route for fetching orders data
    Route::get('/api/orders', [StudentController::class, 'orders'])->name('api.orders')->middleware('auth');


    // Other public routes
    Route::view('/about', 'about')->name('about');
    //Route::view('/accountsettings', 'accountsettings')->name('accountsettings');
    Route::view('accountslayout', 'accountslayout')->name('accountslayout')->middleware('auth');
    
    Route::get('/accountsettings', [StudentController::class, 'accountsettings'])->name('accountsettings')->middleware('auth');
    Route::post('/account/update', [StudentController::class, 'update'])->name('account.update');

    Route::get('/test-auth', function () {
        Log::info('Auth test', ['user' => Auth::user()]);
        return response()->json(['user' => Auth::user()]);
    })->middleware('auth');
}); 

// Admin routes
Route::name('admin.')->group(function () {
    Route::view('/adminslayout', 'adminslayout')->name('adminslayout')->middleware('auth');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::get('/orderManage', [OrderController::class, 'index'])->name('orderManage')->middleware('auth');
    Route::get('/productcatalog', [AdminUniformController::class, 'index'])->name('productcatalog')->middleware('auth');
    Route::resource('uniforms', AdminUniformController::class);
        // Use POST instead of PUT to avoid method spoofing issues
    Route::post('/uniforms/update/{uniform_id}', [AdminUniformController::class, 'update'])->name('uniforms.update');
    // User management routes
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index')->middleware('auth');
    Route::delete('/users/{user_id}', [UserManagementController::class, 'destroy'])->name('users.destroy')->middleware('auth');
});

Route::prefix('admin/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->middleware('auth');
    Route::get('/{order}', [OrderController::class, 'show'])->middleware('auth');
    Route::post('/{order}/status', [OrderController::class, 'updateStatus']);
    Route::post('/{order}/notes', [OrderController::class, 'addNote']);
    Route::delete('/{order}', [OrderController::class, 'cancel']);
});

