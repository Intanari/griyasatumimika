<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Donation routes
Route::get('/donasi', [DonationController::class, 'showForm'])->name('donation.form');
Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
Route::get('/donasi/{donation}/bayar', [DonationController::class, 'showPayment'])->name('donation.payment');
Route::get('/donasi/{donation}/status', [DonationController::class, 'checkStatus'])->name('donation.check');
Route::get('/donasi/{donation}/sukses', [DonationController::class, 'success'])->name('donation.success');

// Midtrans payment notification callback (CSRF excluded in bootstrap/app.php)
Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donation.callback');
