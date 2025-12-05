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


// --- Auth Routes (Dashboard/Logout) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        // You can redirect to home or show a specific admin dashboard
        return redirect()->route('home');
    })->name('dashboard');
});

Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

// Or whatever your controller is named

Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');