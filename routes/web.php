<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PatientScheduleController;
use App\Http\Controllers\OdgjReportController;
use App\Http\Controllers\ExaminationHistoryController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================
// Domain Utama (griyasatumimika.web.id) - Halaman Publik
// ============================================================
$mainDomain = config('app.main_domain');
Route::domain($mainDomain)->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});

// ============================================================
// Domain Admin (admin.griyasatumimika.web.id) - Login & Dashboard
// Wajib login sebelum akses dashboard
// ============================================================
Route::domain(config('app.admin_domain'))->group(function () {
    // Root admin: redirect ke login atau dashboard
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    });

    // Auth Routes (Guest Only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');

        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    // Dashboard (Auth Required - wajib login)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/donasi', [DashboardController::class, 'donasi'])->name('dashboard.donasi');
        Route::get('/dashboard/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
        Route::post('/dashboard/laporan/{laporan}/terima', [DashboardController::class, 'terimaLaporan'])->name('dashboard.laporan.terima');
        Route::post('/dashboard/laporan/{laporan}/tolak', [DashboardController::class, 'tolakLaporan'])->name('dashboard.laporan.tolak');

        Route::resource('dashboard/patients', PatientController::class)->parameters(['patients' => 'patient'])->names([
            'index'   => 'dashboard.patients.index',
            'create'  => 'dashboard.patients.create',
            'store'   => 'dashboard.patients.store',
            'show'    => 'dashboard.patients.show',
            'edit'    => 'dashboard.patients.edit',
            'update'  => 'dashboard.patients.update',
            'destroy' => 'dashboard.patients.destroy',
        ]);

        Route::resource('dashboard/riwayat-pemeriksaan', ExaminationHistoryController::class)->parameters(['riwayat_pemeriksaan' => 'examination_history'])->names([
            'index'   => 'dashboard.riwayat-pemeriksaan.index',
            'create'  => 'dashboard.riwayat-pemeriksaan.create',
            'store'   => 'dashboard.riwayat-pemeriksaan.store',
            'show'    => 'dashboard.riwayat-pemeriksaan.show',
            'edit'    => 'dashboard.riwayat-pemeriksaan.edit',
            'update'  => 'dashboard.riwayat-pemeriksaan.update',
            'destroy' => 'dashboard.riwayat-pemeriksaan.destroy',
        ]);

        Route::resource('dashboard/jadwal-pasien', PatientScheduleController::class)->parameters(['jadwal-pasien' => 'jadwal_pasien'])->names([
            'index'   => 'dashboard.jadwal-pasien.index',
            'create'  => 'dashboard.jadwal-pasien.create',
            'store'   => 'dashboard.jadwal-pasien.store',
            'edit'    => 'dashboard.jadwal-pasien.edit',
            'update'  => 'dashboard.jadwal-pasien.update',
            'destroy' => 'dashboard.jadwal-pasien.destroy',
        ]);
    });
});

// ============================================================
// Domain Utama - Routes Publik (donasi, laporan)
// ============================================================
Route::domain($mainDomain)->group(function () {
    Route::get('/laporan-odgj', [OdgjReportController::class, 'showForm'])->name('odgj-report.form');
    Route::post('/laporan-odgj', [OdgjReportController::class, 'store'])->name('odgj-report.store');

    Route::get('/donasi', [DonationController::class, 'showForm'])->name('donation.form');
    Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/donasi/{donation}/bayar', [DonationController::class, 'showPayment'])->name('donation.payment');
    Route::get('/donasi/{donation}/status', [DonationController::class, 'checkStatus'])->name('donation.check');
    Route::get('/donasi/{donation}/sukses', [DonationController::class, 'success'])->name('donation.success');

    // Midtrans callback (webhook dari Midtrans)
    Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donation.callback');
});
