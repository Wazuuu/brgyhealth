<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\RequestController;

// --- Public Home Page ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Guest Routes (Login/Signup) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- Auth Routes (Protected Pages) ---
// Anything inside this group requires the user to be logged in
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // MOVED: Appointment routes are now protected
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    // OPTIONAL: You likely want to protect requests too
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
});

Route::post('/health-profile', [RequestController::class, 'store'])->name('health_profile.store');

Route::middleware('auth')->group(function () {
    // ... existing routes ...
    
    // Add this new route
    Route::post('/requests/submit', [RequestController::class, 'submitChange'])->name('requests.submit');
});