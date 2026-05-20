<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

// routes/web.php
Route::get('/', [HomeController::class, 'index'])->middleware('jwt.optional')->name('home');
Route::get('/jelajah', [HomeController::class, 'explore'])->middleware('jwt.optional')->name('fields.explore');

Route::prefix('auth')->group(function () {
    // route login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('LoginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // route register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('RegisterPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware(['jwt.verify'])->group(function () {

    // Route Khusus Admin (Wajib login & Admin)
    Route::prefix('admin')->middleware(['is_admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');
        Route::post('/orders', [AdminController::class, 'storeOrder'])->name('admin.orders.store');

        Route::get('/fields', [AdminController::class, 'fields'])->name('admin.fields');
        Route::post('/fields', [AdminController::class, 'storeField'])->name('admin.fields.store');
        Route::put('/fields/{id}', [AdminController::class, 'updateField'])->name('admin.fields.update');
        Route::delete('/fields/{id}', [AdminController::class, 'deleteField'])->name('admin.fields.delete');


        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    });

    // Route Khusus Customer (Wajib login)
    Route::prefix('customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
        // Rute untuk menampilkan halaman booking (sudah ada sebelumnya)
        Route::get('/booking/{id}', [CustomerController::class, 'bookingPage'])->middleware('jwt.optional')->name('booking.page');

        // TAMBAHKAN INI: Rute untuk memproses pengiriman form booking
        Route::post('/booking/store', [CustomerController::class, 'storeBooking'])->middleware('jwt.optional')->name('booking.store');

        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    });





    // Route Khusus Logout (Wajib login)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
