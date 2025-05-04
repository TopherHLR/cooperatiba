<?php

use Illuminate\Support\Facades\Route;

// Main website routes
Route::name('web.')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home'); // Accessible as route('web.welcome')
    
    Route::get('/home', function () {
        return view('home');
    })->name('home'); // Accessible as route('web.home')

    Route::get('/items', function () {
        return view('items');
    })->name('items'); // Accessible as route('web.home')
    Route::get('/login', function () {
        return view('login');
    })->name('login'); // Accessible as route('web.home')
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders'); // Accessible as route('web.home')
});