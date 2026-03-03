<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\OdgjReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ============================================================
// Auth Routes (Guest Only)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// ============================================================
// Logout Route
// ============================================================
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// Protected Routes (Auth Required)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/donasi', [DashboardController::class, 'donasi'])->name('dashboard.donasi');
    Route::get('/dashboard/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
});

// ODGJ Report routes (public)
Route::get('/laporan-odgj', [OdgjReportController::class, 'showForm'])->name('odgj-report.form');
Route::post('/laporan-odgj', [OdgjReportController::class, 'store'])->name('odgj-report.store');

// Donation routes
Route::get('/donasi', [DonationController::class, 'showForm'])->name('donation.form');
Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
Route::get('/donasi/{donation}/bayar', [DonationController::class, 'showPayment'])->name('donation.payment');
Route::get('/donasi/{donation}/status', [DonationController::class, 'checkStatus'])->name('donation.check');
Route::get('/donasi/{donation}/sukses', [DonationController::class, 'success'])->name('donation.success');

// Midtrans payment notification callback (CSRF excluded in bootstrap/app.php)
Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donation.callback');
