<?php

use Illuminate\Support\Facades\Route;

// Main website routes
Route::name('web.')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome'); // Accessible as route('web.welcome')
    
    Route::get('/home', function () {
        return view('home');
    })->name('home'); // Accessible as route('web.home')
});