<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\InventoryController; // <--- Added this

// --- Public Home Page ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Guest Routes (Login/Signup/OTP/Password Reset) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Google Routes
    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

    // OTP Routes
    Route::get('otp-verify', [TwoFactorController::class, 'show'])->name('otp.verify');
    Route::post('otp-verify', [TwoFactorController::class, 'verify'])->name('otp.check');

    // Forgot Password Routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
    
    Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// --- Auth Routes (Protected User Pages) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // User Appointments
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    // User Requests
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests/submit', [RequestController::class, 'submitChange'])->name('requests.submit');
    
    // Health Profile Store
    Route::post('/health-profile', [RequestController::class, 'store'])->name('health_profile.store');
});

// --- ADMIN ROUTES (Protected by Admin Middleware) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // =========================================================
    // RESIDENT ROUTES
    // =========================================================

    // A. Specific Pages
    Route::get('/residents/archived', [AdminController::class, 'archivedResidents'])->name('residents.archived');
    Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
    
    // B. Main List & Store
    Route::get('/residents', [AdminController::class, 'residents'])->name('residents');
    Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');

    // C. Wildcard Routes (Must come LAST)
    Route::get('/residents/{id}', [ResidentController::class, 'show'])->name('residents.show');
    Route::get('/residents/{id}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
    Route::post('/residents/{id}', [ResidentController::class, 'update'])->name('residents.update');
    Route::post('/residents/{id}/archive', [ResidentController::class, 'archive'])->name('residents.archive');
    Route::post('/residents/{id}/restore', [ResidentController::class, 'restore'])->name('residents.restore');

    // =========================================================
    // INVENTORY ROUTES (Added)
    // =========================================================
    Route::resource('inventory', InventoryController::class);

    // =========================================================
    // OTHER ADMIN ROUTES
    // =========================================================

    // Appointments Management
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::post('/appointments/{id}/approve', [AdminController::class, 'approveAppointment'])->name('appointments.approve');

    // Change Requests Management
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::post('/requests/{id}/approve', [AdminController::class, 'approveRequest'])->name('requests.approve');
});