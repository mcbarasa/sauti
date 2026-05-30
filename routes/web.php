<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Auth\LoginController;

// ── Public routes ────────────────────────────────────────────────────
Route::get('/',     [BookingController::class, 'index'])->name('home');

// Change form action from bookings.store to bookings.initiate
Route::get('/book',  [BookingController::class, 'create'])->name('bookings.create');
Route::post('/book',                  [BookingController::class, 'initiate'])->name('bookings.initiate');
Route::get('/book/check-payment',     [BookingController::class, 'checkMpesaPayment'])->name('bookings.check-payment');
Route::post('/mpesa/callback',        [BookingController::class, 'mpesaCallback'])->name('mpesa.callback');

Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/api/slots', [BookingController::class, 'slotsForMonth'])->name('bookings.slots');

// Instead of /admin/bookings use something non-guessable
Route::prefix('dashboard-sg')->middleware('auth')->group(function () {
    Route::get('/',                        [BookingController::class, 'adminIndex'])->name('bookings.admin');
    Route::delete('/bookings/{booking}',   [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
});

// Login at a non-obvious path too
Route::get('/sg-access',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/sg-access', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/sg-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// Add this INSIDE your auth middleware group
Route::middleware('auth')->group(function () {
    Route::get('/api/live-timers', [BookingController::class, 'liveTimers'])->name('bookings.live-timers');
    
    // ... your other protected routes
});

//checkout routes
Route::middleware('auth')->group(function () {
    // ... existing routes ...
    Route::patch('/admin/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

Route::post('/book/preview-recurring',        [BookingController::class, 'previewRecurring'])->name('bookings.preview-recurring');
Route::post('/book/store-recurring',          [BookingController::class, 'storeRecurring'])->name('bookings.store-recurring');
Route::get('/bookings/recurring/{group}',     [BookingController::class, 'recurringConfirmation'])->name('bookings.recurring.confirmation');

// checkout routing
Route::patch('/admin/bookings/{booking}/checkout-confirm', [BookingController::class, 'checkoutConfirm'])
    ->name('bookings.checkout.confirm');

Route::delete('/admin/bookings/{booking}/delete', [BookingController::class, 'hardDelete'])
    ->name('bookings.delete');