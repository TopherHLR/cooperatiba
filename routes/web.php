<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminUniformController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Correct Request class
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
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

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
    Route::get('/orderManage', [OrderController::class, 'index'])->name('orderManage')->middleware('auth');
    Route::get('/productcatalog', [AdminUniformController::class, 'index'])->name('productcatalog')->middleware('auth');
    Route::resource('uniforms', AdminUniformController::class);
        // Use POST instead of PUT to avoid method spoofing issues
    Route::post('/uniforms/update/{uniform_id}', [AdminUniformController::class, 'update'])->name('uniforms.update');
    // User management routes
    Route::get('/users', [UserManagementController::class, 'usermanage'])->name('users.index')->middleware('auth');
    Route::delete('/users/{user_id}', [UserManagementController::class, 'destroy'])->name('users.destroy')->middleware('auth');
});

Route::prefix('admin/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->middleware('auth');
    Route::get('/{order}', [OrderController::class, 'show'])->middleware('auth');
    Route::post('/{order}/status', [OrderController::class, 'updateStatus']);
    Route::post('/{order}/notes', [OrderController::class, 'addNote']);
    Route::delete('/{order}', [OrderController::class, 'cancel']);
});

Route::middleware(['auth'])->group(function () {
    // Display the chat page with messages
    Route::get('/chats', [ChatController::class, 'index'])->name('student.chat');

    // Handle sending of new messages
    Route::post('/chats/send', [ChatController::class, 'sendMessage'])->name('student.chat.send');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/chats/{studentId?}', action: [AdminChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/admin/chats/{studentId}/send', [AdminChatController::class, 'sendMessage'])->name('admin.chat.send');
});

Route::get('/search', [SearchController::class, 'search'])->name(name: 'search');
Route::post('/notifications/mark-read', [NotificationController::class, 'markNotificationsAsRead']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('web.login.submit')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');