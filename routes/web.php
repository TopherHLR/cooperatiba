<?php

use Illuminate\Support\Facades\Route;

// Main website routes
Route::name('web.')->group(function () {
    // Public routes (direct views from root)
    Route::view('/', 'home')->name('home');
    Route::view('/home', 'home')->name('home');
    Route::view('/items', 'items')->name('items');
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::view('/payment', 'payment')->name('payment');
    Route::view('/about', 'about')->name('about');
    Route::view('/accountsettings', 'accountsettings')->name('accountsettings');
    Route::view('/orders', 'orders')->name('orders');
    Route::view('accountslayout', 'accountslayout')->name('accountslayout');
});
// Main website routes
Route::name('admin.')->group(function () {
    Route::view('/admin', 'admin')->name('admin');
});