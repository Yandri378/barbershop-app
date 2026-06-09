<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReviewController;

// ============================================
// Public Routes
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// Authentication Routes
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ============================================
// Customer Routes
// ============================================
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // AJAX - Get available slots
    Route::get('/bookings/slots/available', [BookingController::class, 'getAvailableSlots'])->name('bookings.slots');

    // Payments
    Route::get('/payments/{booking}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{booking}/confirmation', [PaymentController::class, 'showConfirmation'])->name('payments.confirmation');
    Route::post('/payments/{booking}/submit', [PaymentController::class, 'submitPayment'])->name('payments.submit');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ============================================
// Admin Routes
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Bookings Management
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'bookings'])->name('index');
        Route::get('/{booking}', [AdminDashboardController::class, 'showBooking'])->name('show');
        Route::post('/{booking}/approve', [AdminDashboardController::class, 'approveBooking'])->name('approve');
        Route::post('/{booking}/reject', [AdminDashboardController::class, 'rejectBooking'])->name('reject');
        Route::post('/{booking}/complete', [AdminDashboardController::class, 'completeBooking'])->name('complete');
    });

    // Barbers Management
    Route::prefix('barbers')->name('barbers.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'barbers'])->name('index');
        Route::get('/create', [AdminDashboardController::class, 'createBarber'])->name('create');
        Route::post('/', [AdminDashboardController::class, 'storeBarber'])->name('store');
        Route::get('/{barber}/edit', [AdminDashboardController::class, 'editBarber'])->name('edit');
        Route::put('/{barber}', [AdminDashboardController::class, 'updateBarber'])->name('update');
        Route::delete('/{barber}', [AdminDashboardController::class, 'deleteBarber'])->name('delete');
    });

    // Services Management
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'services'])->name('index');
        Route::get('/create', [AdminDashboardController::class, 'createService'])->name('create');
        Route::post('/', [AdminDashboardController::class, 'storeService'])->name('store');
        Route::get('/{service}/edit', [AdminDashboardController::class, 'editService'])->name('edit');
        Route::put('/{service}', [AdminDashboardController::class, 'updateService'])->name('update');
        Route::delete('/{service}', [AdminDashboardController::class, 'deleteService'])->name('delete');
    });

    // Payments Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [PaymentController::class, 'showAdmin'])->name('show');
        Route::post('/{payment}/mark-as-paid', [PaymentController::class, 'markAsPaid'])->name('mark-paid');
        Route::post('/{payment}/mark-as-failed', [PaymentController::class, 'markAsFailed'])->name('mark-failed');
    });
});
