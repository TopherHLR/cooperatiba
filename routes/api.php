<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminUniformController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Auth;

Route::middleware('auth:sanctum')->group(function () {
    // User orders routes
    Route::prefix('user')->group(function () {
        Route::get('/orders', [UserOrderController::class, 'index']);
        Route::get('/orders/{order}', [UserOrderController::class, 'show']);
    });
});