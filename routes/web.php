<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\StudentController;
// Main website routes
Route::name('web.')->group(function () {
    // Public routes (direct views from root)
    Route::view('/', 'home')->name('home');
    Route::view('/home', 'home')->name('home');
    
    // Uniform items route - now using controller but pointing to existing items.blade.php
    Route::get('/items', [UniformController::class, 'index'])->name('items');
    
    // Authentication routes
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
       // Add logic routes for login/register (POST)
    Route::post('/login', [StudentController::class, 'login'])->name('login.submit');
    Route::post('/register', [StudentController::class, 'register'])->name('register.submit');

    // Optional logout
    Route::post('/logout', [StudentController::class, 'logout'])->name('logout');

    // Payment and order routes
    Route::view('/payment', 'payment')->name('payment');
    Route::view('/orders', 'orders')->name('orders');
    
    // Other public routes
    Route::view('/about', 'about')->name('about');
    Route::view('/accountsettings', 'accountsettings')->name('accountsettings');
    Route::view('accountslayout', 'accountslayout')->name('accountslayout');
    
});

// Admin routes
Route::name('admin.')->group(function () {
    Route::view('/adminslayout', 'adminslayout')->name('adminslayout');
    Route::view('/orderManage', 'orderManage')->name('orderManage');
    
    // You might want to add admin uniform management routes here later
    // Route::resource('admin/uniforms', AdminUniformController::class);
});