<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationExpenseController;
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
use App\Http\Controllers\TransparansiDonasiController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\ProfilYayasanController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\PetugasYayasanController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProsesLaporanOdgjController;
use App\Http\Controllers\TahapanRehabilitasiController;
use App\Http\Controllers\PublicPatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================
// Domain Utama (griyasatumimika.web.id) - Halaman Publik
// ============================================================
$mainDomain = config('app.main_domain');
Route::domain($mainDomain)->group(function () {
    Route::get('/', function () {
        return view('public.home');
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
        Route::get('/dashboard/tentang-sistem', [DashboardController::class, 'about'])->name('dashboard.about');
        Route::get('/dashboard/donasi', [DashboardController::class, 'donasi'])->name('dashboard.donasi');
        Route::resource('dashboard/donasi/pengeluaran', DonationExpenseController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->parameters(['pengeluaran' => 'donation_expense'])->names([
            'create'  => 'dashboard.donasi.pengeluaran.create',
            'store'   => 'dashboard.donasi.pengeluaran.store',
            'edit'    => 'dashboard.donasi.pengeluaran.edit',
            'update'  => 'dashboard.donasi.pengeluaran.update',
            'destroy' => 'dashboard.donasi.pengeluaran.destroy',
        ]);
        Route::get('/dashboard/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
        Route::get('/dashboard/laporan/{laporan}', [DashboardController::class, 'showLaporan'])->name('dashboard.laporan.show');
        Route::post('/dashboard/laporan/{laporan}/terima', [DashboardController::class, 'terimaLaporan'])->name('dashboard.laporan.terima');
        Route::post('/dashboard/laporan/{laporan}/tolak', [DashboardController::class, 'tolakLaporan'])->name('dashboard.laporan.tolak');
        Route::post('/dashboard/laporan/{laporan}/respon', [DashboardController::class, 'kirimResponLaporan'])->name('dashboard.laporan.respon');

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
            'show'    => 'dashboard.jadwal-pasien.show',
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
        Route::get('dashboard/stock/tambah', [StockController::class, 'createSupply'])->name('dashboard.stock.tambah');
        Route::post('dashboard/stock/tambah', [StockController::class, 'storeSupply'])->name('dashboard.stock.tambah.store');
        Route::get('dashboard/stock/persediaan/{stock_supply}', [StockController::class, 'showSupply'])->name('dashboard.stock.persediaan.show');
        Route::get('dashboard/stock/persediaan/{stock_supply}/edit', [StockController::class, 'editSupply'])->name('dashboard.stock.persediaan.edit');
        Route::put('dashboard/stock/persediaan/{stock_supply}', [StockController::class, 'updateSupply'])->name('dashboard.stock.persediaan.update');
        Route::delete('dashboard/stock/persediaan/{stock_supply}', [StockController::class, 'destroySupply'])->name('dashboard.stock.persediaan.destroy');
        Route::get('dashboard/stock/pengeluaran/create', [StockController::class, 'createExpense'])->name('dashboard.stock.pengeluaran.create');
        Route::post('dashboard/stock/pengeluaran', [StockController::class, 'storeExpense'])->name('dashboard.stock.pengeluaran.store');
        Route::get('dashboard/stock/pengeluaran/{stock_expense}', [StockController::class, 'showExpense'])->name('dashboard.stock.pengeluaran.show');
        Route::get('dashboard/stock/pengeluaran/{stock_expense}/edit', [StockController::class, 'editExpense'])->name('dashboard.stock.pengeluaran.edit');
        Route::put('dashboard/stock/pengeluaran/{stock_expense}', [StockController::class, 'updateExpense'])->name('dashboard.stock.pengeluaran.update');
        Route::delete('dashboard/stock/pengeluaran/{stock_expense}', [StockController::class, 'destroyExpense'])->name('dashboard.stock.pengeluaran.destroy');
        Route::post('dashboard/stock/out', [StockController::class, 'stockOut'])->name('dashboard.stock.out');
        Route::get('dashboard/stock/{stock}', [StockController::class, 'show'])->name('dashboard.stock.show');
        Route::resource('dashboard/stock', StockController::class)->only(['index', 'store', 'update', 'destroy'])->parameters(['stock' => 'stock'])->names([
            'index' => 'dashboard.stock.index',
            'store' => 'dashboard.stock.store',
            'update' => 'dashboard.stock.update',
            'destroy' => 'dashboard.stock.destroy',
        ]);
        Route::resource('dashboard/admin-users', AdminUserController::class)->parameters(['admin-users' => 'admin_user'])->names([
            'index'   => 'dashboard.admin-users.index',
            'create'  => 'dashboard.admin-users.create',
            'store'   => 'dashboard.admin-users.store',
            'edit'    => 'dashboard.admin-users.edit',
            'update'  => 'dashboard.admin-users.update',
            'destroy' => 'dashboard.admin-users.destroy',
        ])->except(['show']);
        Route::put('dashboard/admin-users/{admin_user}/profile', [AdminUserController::class, 'updateProfile'])->name('dashboard.admin-users.update-profile');
        Route::put('dashboard/admin-users/{admin_user}/password', [AdminUserController::class, 'updatePassword'])->name('dashboard.admin-users.update-password');
        Route::put('dashboard/admin-users/{admin_user}/role', [AdminUserController::class, 'updateRole'])->name('dashboard.admin-users.update-role');
        Route::resource('dashboard/petugas', PetugasController::class)->parameters(['petuga' => 'petuga'])->names([
            'index'   => 'dashboard.petugas.index',
            'create'  => 'dashboard.petugas.create',
            'store'   => 'dashboard.petugas.store',
            'show'    => 'dashboard.petugas.show',
            'edit'    => 'dashboard.petugas.edit',
            'update'  => 'dashboard.petugas.update',
            'destroy' => 'dashboard.petugas.destroy',
        ]);

        Route::get('/dashboard/pengaturan-web', [WebSettingController::class, 'index'])->name('dashboard.web-settings.index');
        Route::post('/dashboard/pengaturan-web/warna', [WebSettingController::class, 'saveColors'])->name('dashboard.web-settings.save-colors');
        Route::post('/dashboard/pengaturan-web/p-colors', [WebSettingController::class, 'savePColors'])->name('dashboard.web-settings.save-p-colors');
        Route::post('/dashboard/pengaturan-web/span-colors', [WebSettingController::class, 'saveSpanColors'])->name('dashboard.web-settings.save-span-colors');
        Route::post('/dashboard/pengaturan-web/div-colors', [WebSettingController::class, 'saveDivColors'])->name('dashboard.web-settings.save-div-colors');
        Route::post('/dashboard/pengaturan-web/link-colors', [WebSettingController::class, 'saveLinkColors'])->name('dashboard.web-settings.save-link-colors');
        Route::post('/dashboard/pengaturan-web/button-colors', [WebSettingController::class, 'saveButtonColors'])->name('dashboard.web-settings.save-button-colors');
        Route::post('/dashboard/pengaturan-web/custom-class-colors', [WebSettingController::class, 'saveCustomClassColors'])->name('dashboard.web-settings.save-custom-class-colors');
        Route::post('/dashboard/pengaturan-web/background', [WebSettingController::class, 'saveBackground'])->name('dashboard.web-settings.save-background');

        Route::get('/dashboard/profil-yayasan', [ProfilYayasanController::class, 'index'])->name('dashboard.profil-yayasan.index');
        Route::get('/dashboard/profil-yayasan/create', [ProfilYayasanController::class, 'create'])->name('dashboard.profil-yayasan.create');
        Route::post('/dashboard/profil-yayasan', [ProfilYayasanController::class, 'store'])->name('dashboard.profil-yayasan.store');
        Route::get('/dashboard/profil-yayasan/{profilYayasan}', [ProfilYayasanController::class, 'show'])->name('dashboard.profil-yayasan.show');
        Route::get('/dashboard/profil-yayasan/{profilYayasan}/edit', [ProfilYayasanController::class, 'edit'])->name('dashboard.profil-yayasan.edit');
        Route::put('/dashboard/profil-yayasan/{profilYayasan}', [ProfilYayasanController::class, 'update'])->name('dashboard.profil-yayasan.update');
        Route::delete('/dashboard/profil-yayasan/{profilYayasan}', [ProfilYayasanController::class, 'destroy'])->name('dashboard.profil-yayasan.destroy');

        Route::get('/dashboard/profil-struktur', [StrukturOrganisasiController::class, 'index'])->name('dashboard.profil-struktur.index');
        Route::put('/dashboard/profil-struktur/kepengurusan', [StrukturOrganisasiController::class, 'updateKepengurusan'])->name('dashboard.profil-struktur.update-kepengurusan');
        Route::get('/dashboard/petugas-yayasan/create', [PetugasYayasanController::class, 'create'])->name('dashboard.petugas-yayasan.create');
        Route::post('/dashboard/petugas-yayasan', [PetugasYayasanController::class, 'store'])->name('dashboard.petugas-yayasan.store');
        Route::get('/dashboard/petugas-yayasan/{petugasYayasan}', [PetugasYayasanController::class, 'show'])->name('dashboard.petugas-yayasan.show');
        Route::get('/dashboard/petugas-yayasan/{petugasYayasan}/edit', [PetugasYayasanController::class, 'edit'])->name('dashboard.petugas-yayasan.edit');
        Route::put('/dashboard/petugas-yayasan/{petugasYayasan}', [PetugasYayasanController::class, 'update'])->name('dashboard.petugas-yayasan.update');
        Route::delete('/dashboard/petugas-yayasan/{petugasYayasan}', [PetugasYayasanController::class, 'destroy'])->name('dashboard.petugas-yayasan.destroy');

        Route::get('/dashboard/visi-misi', [VisiMisiController::class, 'index'])->name('dashboard.visi-misi.index');
        Route::get('/dashboard/visi-misi/create', [VisiMisiController::class, 'create'])->name('dashboard.visi-misi.create');
        Route::post('/dashboard/visi-misi', [VisiMisiController::class, 'store'])->name('dashboard.visi-misi.store');
        Route::get('/dashboard/visi-misi/{visiMisi}', [VisiMisiController::class, 'show'])->name('dashboard.visi-misi.show');
        Route::get('/dashboard/visi-misi/{visiMisi}/edit', [VisiMisiController::class, 'edit'])->name('dashboard.visi-misi.edit');
        Route::put('/dashboard/visi-misi/{visiMisi}', [VisiMisiController::class, 'update'])->name('dashboard.visi-misi.update');
        Route::delete('/dashboard/visi-misi/{visiMisi}', [VisiMisiController::class, 'destroy'])->name('dashboard.visi-misi.destroy');

        Route::get('/dashboard/layanan', [LayananController::class, 'index'])->name('dashboard.layanan.index');
        Route::get('/dashboard/layanan/proses-laporan-odgj/create', [ProsesLaporanOdgjController::class, 'create'])->name('dashboard.layanan.proses-laporan-odgj.create');
        Route::post('/dashboard/layanan/proses-laporan-odgj', [ProsesLaporanOdgjController::class, 'store'])->name('dashboard.layanan.proses-laporan-odgj.store');
        Route::get('/dashboard/layanan/proses-laporan-odgj/{prosesLaporanOdgj}', [ProsesLaporanOdgjController::class, 'show'])->name('dashboard.layanan.proses-laporan-odgj.show');
        Route::get('/dashboard/layanan/proses-laporan-odgj/{prosesLaporanOdgj}/edit', [ProsesLaporanOdgjController::class, 'edit'])->name('dashboard.layanan.proses-laporan-odgj.edit');
        Route::put('/dashboard/layanan/proses-laporan-odgj/{prosesLaporanOdgj}', [ProsesLaporanOdgjController::class, 'update'])->name('dashboard.layanan.proses-laporan-odgj.update');
        Route::delete('/dashboard/layanan/proses-laporan-odgj/{prosesLaporanOdgj}', [ProsesLaporanOdgjController::class, 'destroy'])->name('dashboard.layanan.proses-laporan-odgj.destroy');
        Route::get('/dashboard/layanan/tahapan-rehabilitasi/create', [TahapanRehabilitasiController::class, 'create'])->name('dashboard.layanan.tahapan-rehabilitasi.create');
        Route::post('/dashboard/layanan/tahapan-rehabilitasi', [TahapanRehabilitasiController::class, 'store'])->name('dashboard.layanan.tahapan-rehabilitasi.store');
        Route::get('/dashboard/layanan/tahapan-rehabilitasi/{tahapanRehabilitasi}', [TahapanRehabilitasiController::class, 'show'])->name('dashboard.layanan.tahapan-rehabilitasi.show');
        Route::get('/dashboard/layanan/tahapan-rehabilitasi/{tahapanRehabilitasi}/edit', [TahapanRehabilitasiController::class, 'edit'])->name('dashboard.layanan.tahapan-rehabilitasi.edit');
        Route::put('/dashboard/layanan/tahapan-rehabilitasi/{tahapanRehabilitasi}', [TahapanRehabilitasiController::class, 'update'])->name('dashboard.layanan.tahapan-rehabilitasi.update');
        Route::delete('/dashboard/layanan/tahapan-rehabilitasi/{tahapanRehabilitasi}', [TahapanRehabilitasiController::class, 'destroy'])->name('dashboard.layanan.tahapan-rehabilitasi.destroy');
    });
});

// ============================================================
// Domain Utama - Routes Publik (profil, donasi, laporan)
// ============================================================
Route::domain($mainDomain)->group(function () {
    Route::redirect('/tentang', '/profil', 301);
    Route::get('/profil', fn () => view('public.pages.profil'))->name('pages.profil');
    Route::get('/layanan', function () {
        $prosesLaporanOdgj = \App\Models\ProsesLaporanOdgj::orderBy('no_urut')->orderBy('id')->get();
        $tahapanRehabilitasi = \App\Models\TahapanRehabilitasi::orderBy('no_urut')->orderBy('id')->get();
        return view('public.pages.layanan', compact('prosesLaporanOdgj', 'tahapanRehabilitasi'));
    })->name('pages.layanan');
    Route::get('/galeri', function () {
        $activities = \App\Models\PatientActivity::with('patient')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderByDesc('tanggal')
            ->get();
        return view('public.pages.galeri', compact('activities'));
    })->name('pages.galeri');
    Route::get('/kontak', fn () => view('public.pages.kontak'))->name('pages.kontak');
    Route::get('/cara-donasi', fn () => view('public.pages.cara-donasi'))->name('pages.cara-donasi');
    Route::get('/mitra', fn () => view('public.pages.mitra'))->name('pages.mitra');
    Route::get('/faq', fn () => view('public.pages.faq'))->name('pages.faq');

    Route::get('/profil/yayasan', function () {
        $profilItems = \App\Models\ProfilYayasan::orderBy('created_at')->get();
        return view('public.pages.profil.yayasan', compact('profilItems'));
    })->name('profil.yayasan');

    Route::get('/profil/visi-misi', function () {
        $visiMisiItems = \App\Models\VisiMisi::orderBy('created_at')->get();
        return view('public.pages.profil.visi-misi', compact('visiMisiItems'));
    })->name('profil.visi-misi');

    Route::get('/profil/struktur-organisasi', function () {
        $order = ['pembina', 'ketua_yayasan', 'ketua_pengawas', 'sekretaris', 'bendahara', 'pengawas'];
        $kepengurusan = \App\Models\StrukturKepengurusan::all()->sortBy(fn ($m) => array_search($m->role, $order))->values();
        $petugas = \App\Models\PetugasYayasan::orderBy('urutan')->orderBy('nama')->get();
        return view('public.pages.profil.struktur-organisasi', compact('kepengurusan', 'petugas'));
    })->name('profil.struktur');

    Route::get('/laporan-odgj', [OdgjReportController::class, 'showForm'])->name('odgj-report.form');
    Route::post('/laporan-odgj', [OdgjReportController::class, 'store'])->name('odgj-report.store');
    Route::get('/laporan-odgj/{report}/sukses', [OdgjReportController::class, 'success'])->name('odgj-report.success');

    Route::get('/donasi', [DonationController::class, 'showForm'])->name('donation.form');
    Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/donasi/{donation}/bayar', [DonationController::class, 'showPayment'])->name('donation.payment');
    Route::get('/donasi/{donation}/status', [DonationController::class, 'checkStatus'])->name('donation.check');
    Route::get('/donasi/{donation}/sukses', [DonationController::class, 'success'])->name('donation.success');

    // Midtrans callback (webhook dari Midtrans)
    Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donation.callback');

    Route::get('/transparansi-donasi', [TransparansiDonasiController::class, 'index'])->name('transparansi.donasi');
    Route::get('/transparansi-donasi/pdf/donasi', [TransparansiDonasiController::class, 'pdfDonations'])->name('transparansi.donasi.pdf.donations');
    Route::get('/transparansi-donasi/pdf/pengeluaran', [TransparansiDonasiController::class, 'pdfExpenses'])->name('transparansi.donasi.pdf.expenses');

    Route::get('/pasien', [PublicPatientController::class, 'index'])->name('public.pasien.index');
    Route::get('/pasien/{patient}', [PublicPatientController::class, 'show'])->name('public.pasien.show');
});
