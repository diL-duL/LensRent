<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Models\Camera;

Route::get('/', function () {
    $cameras = Camera::all();
    return view('welcome', compact('cameras'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])->name('dashboard');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::post('/rentals/{rental}/payment', [PaymentController::class, 'upload'])->name('payments.upload');

    // Camera detail page (authenticated users only)
    Route::get('/cameras/{camera}', [CameraController::class, 'show'])->name('cameras.show');

    // Profile routes (protected by 'update-profile' gate)
    Route::middleware('can:update-profile')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('cameras', CameraController::class);
    
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
    Route::post('/rentals/{rental}/return', [RentalController::class, 'returnCamera'])->name('admin.rentals.return');
});

