<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Sauti Gang Studio
|--------------------------------------------------------------------------
|
| Landing page with inline booking form  →  GET  /
| Dedicated booking page                 →  GET  /book
| Store new booking                      →  POST /book
| Booking confirmation page              →  GET  /bookings/{booking}
| Admin booking list                     →  GET  /admin/bookings
| Cancel a booking                       →  DELETE /admin/bookings/{booking}
| AJAX: fetch booked slots for a month   →  GET  /api/slots
|
*/

// ── Landing page (home) ──────────────────────────────────────────────────
Route::get('/', [BookingController::class, 'index'])->name('home');

// ── Booking form & store ─────────────────────────────────────────────────
Route::get('/book',            [BookingController::class, 'create'])->name('bookings.create');
Route::post('/book',           [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

// ── Admin panel ──────────────────────────────────────────────────────────
Route::get('/admin/bookings',              [BookingController::class, 'adminIndex'])->name('bookings.admin');
Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

// ── AJAX / calendar API ──────────────────────────────────────────────────
Route::get('/api/slots', [BookingController::class, 'slotsForMonth'])->name('bookings.slots');

Route::patch('/admin/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');