<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminUniformController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Auth;



// User orders route (place first to avoid conflicts)
// Main website routes
Route::name('web.')->group(function () {
    // Public routes (direct views from root)
    Route::view('/', 'home')->name('home');
    Route::view('/home', 'home')->name('home');
    
    // Uniform items route - now using controller but pointing to existing items.blade.php
    Route::get('/items', [UniformController::class, 'index'])->name('items');
    Route::get('/items/{id}', [UniformController::class, 'show'])->name('items.show');
    Route::post('/items/{uniform_id}/buy-now', [UniformController::class, 'buyNow'])->name('items.buyNow');
    Route::get('/payment', [UniformController::class, 'payment'])->name('payment');
    // Authentication routes
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::post('/login', [StudentController::class, 'login'])->name('login.submit');
    Route::post('/register', [StudentController::class, 'register'])->name('register.submit');

    // Optional logout
    Route::post('/logout', [StudentController::class, 'logout'])->name('logout');
    Route::get('/orders', [StudentController::class, 'orders'])->name('orders')->middleware('auth');

    // Payment and order routes
    Route::view('/payment', 'payment')->name('payment');
    
    // Other public routes
    Route::view('/about', 'about')->name('about');
    //Route::view('/accountsettings', 'accountsettings')->name('accountsettings');
    Route::view('accountslayout', 'accountslayout')->name('accountslayout');
    
    Route::get('/accountsettings', [StudentController::class, 'accountsettings'])->name('accountsettings')->middleware('auth');
    Route::post('/account/update', [StudentController::class, 'update'])->name('account.update');

    Route::get('/test-auth', function () {
        Log::info('Auth test', ['user' => Auth::user()]);
        return response()->json(['user' => Auth::user()]);
    })->middleware('auth');
});

// Admin routes
Route::name('admin.')->group(function () {
    Route::view('/adminslayout', 'adminslayout')->name('adminslayout');
    Route::get('/orderManage', [OrderController::class, 'index'])->name('orderManage');
    Route::get('/productcatalog', [AdminUniformController::class, 'index'])->name('productcatalog');
    Route::resource('uniforms', AdminUniformController::class);
        // Use POST instead of PUT to avoid method spoofing issues
    Route::post('/uniforms/update/{uniform_id}', [AdminUniformController::class, 'update'])->name('uniforms.update');
    // You might want to add admin uniform management routes here later
    // Route::resource('admin/uniforms', AdminUniformController::class);
});

Route::prefix('admin/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::post('/{order}/status', [OrderController::class, 'updateStatus']);
    Route::post('/{order}/notes', [OrderController::class, 'addNote']);
    Route::delete('/{order}', [OrderController::class, 'cancel']);
});

