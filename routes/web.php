<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\JadwalPetugasController;
use App\Http\Controllers\PatientScheduleController;
use App\Http\Controllers\RehabilitationScheduleController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\OdgjReportController;
use App\Http\Controllers\ExaminationHistoryController;
use App\Http\Controllers\PatientActivityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StockController;
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

        Route::post('dashboard/patient-activities/store-simple', [PatientActivityController::class, 'storeSimple'])->name('dashboard.patient-activities.store-simple');
        Route::get('dashboard/patient-activities/{patient_activity}/duplicate', [PatientActivityController::class, 'duplicate'])->name('dashboard.patient-activities.duplicate');
        Route::resource('dashboard/patient-activities', PatientActivityController::class)->parameters(['patient-activities' => 'patient_activity'])->names([
            'index'   => 'dashboard.patient-activities.index',
            'create'  => 'dashboard.patient-activities.create',
            'store'   => 'dashboard.patient-activities.store',
            'show'    => 'dashboard.patient-activities.show',
            'edit'    => 'dashboard.patient-activities.edit',
            'update'  => 'dashboard.patient-activities.update',
            'destroy' => 'dashboard.patient-activities.destroy',
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

        Route::get('dashboard/jadwal-rehabilitasi/export/pdf', [RehabilitationScheduleController::class, 'exportPdf'])->name('dashboard.jadwal-rehabilitasi.export.pdf');
        Route::resource('dashboard/jadwal-rehabilitasi', RehabilitationScheduleController::class)->except(['show'])->parameters(['jadwal-rehabilitasi' => 'jadwal_rehabilitasi'])->names([
            'index'   => 'dashboard.jadwal-rehabilitasi.index',
            'create'  => 'dashboard.jadwal-rehabilitasi.create',
            'store'   => 'dashboard.jadwal-rehabilitasi.store',
            'edit'    => 'dashboard.jadwal-rehabilitasi.edit',
            'update'  => 'dashboard.jadwal-rehabilitasi.update',
            'destroy' => 'dashboard.jadwal-rehabilitasi.destroy',
        ]);

        Route::resource('dashboard/jadwal-pasien', PatientScheduleController::class)->parameters(['jadwal-pasien' => 'jadwal_pasien'])->names([
            'index'   => 'dashboard.jadwal-pasien.index',
            'create'  => 'dashboard.jadwal-pasien.create',
            'store'   => 'dashboard.jadwal-pasien.store',
            'edit'    => 'dashboard.jadwal-pasien.edit',
            'update'  => 'dashboard.jadwal-pasien.update',
            'destroy' => 'dashboard.jadwal-pasien.destroy',
        ]);

        Route::resource('dashboard/shifts', ShiftController::class)->parameters(['shifts' => 'shift'])->names([
            'index'   => 'dashboard.shifts.index',
            'create'  => 'dashboard.shifts.create',
            'store'   => 'dashboard.shifts.store',
            'edit'    => 'dashboard.shifts.edit',
            'update'  => 'dashboard.shifts.update',
            'destroy' => 'dashboard.shifts.destroy',
        ]);
        Route::get('dashboard/jadwal-petugas/bulk-create', [JadwalPetugasController::class, 'bulkCreate'])->name('dashboard.jadwal-petugas.bulk-create');
        Route::post('dashboard/jadwal-petugas/bulk-store', [JadwalPetugasController::class, 'bulkStore'])->name('dashboard.jadwal-petugas.bulk-store');
        Route::post('dashboard/jadwal-petugas/store-libur', [JadwalPetugasController::class, 'storeLibur'])->name('dashboard.jadwal-petugas.store-libur');
        Route::post('dashboard/jadwal-petugas/store-ganti', [JadwalPetugasController::class, 'storeGanti'])->name('dashboard.jadwal-petugas.store-ganti');
        Route::get('dashboard/jadwal-petugas/export/pdf', [JadwalPetugasController::class, 'exportPdf'])->name('dashboard.jadwal-petugas.export.pdf');
        Route::get('dashboard/jadwal-petugas/{jadwal_petuga}/duplicate', [JadwalPetugasController::class, 'duplicate'])->name('dashboard.jadwal-petugas.duplicate');
        Route::resource('dashboard/jadwal-petugas', JadwalPetugasController::class)->parameters(['jadwal-petugas' => 'jadwal_petuga'])->names([
            'index'   => 'dashboard.jadwal-petugas.index',
            'create'  => 'dashboard.jadwal-petugas.create',
            'store'   => 'dashboard.jadwal-petugas.store',
            'edit'    => 'dashboard.jadwal-petugas.edit',
            'update'  => 'dashboard.jadwal-petugas.update',
            'destroy' => 'dashboard.jadwal-petugas.destroy',
        ]);

        Route::get('dashboard/petugas/export/excel', [PetugasController::class, 'exportExcel'])->name('dashboard.petugas.export.excel');
        Route::get('dashboard/petugas/export/pdf', [PetugasController::class, 'exportPdf'])->name('dashboard.petugas.export.pdf');
        Route::get('dashboard/stock/export/csv', [StockController::class, 'exportCsv'])->name('dashboard.stock.export.csv');
        Route::post('dashboard/stock/out', [StockController::class, 'stockOut'])->name('dashboard.stock.out');
        Route::get('dashboard/stock/{stock}', [StockController::class, 'show'])->name('dashboard.stock.show');
        Route::resource('dashboard/stock', StockController::class)->only(['index', 'store', 'update', 'destroy'])->parameters(['stock' => 'stock'])->names([
            'index' => 'dashboard.stock.index',
            'store' => 'dashboard.stock.store',
            'update' => 'dashboard.stock.update',
            'destroy' => 'dashboard.stock.destroy',
        ]);
        Route::resource('dashboard/petugas', PetugasController::class)->parameters(['petuga' => 'petuga'])->names([
            'index'   => 'dashboard.petugas.index',
            'create'  => 'dashboard.petugas.create',
            'store'   => 'dashboard.petugas.store',
            'show'    => 'dashboard.petugas.show',
            'edit'    => 'dashboard.petugas.edit',
            'update'  => 'dashboard.petugas.update',
            'destroy' => 'dashboard.petugas.destroy',
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
