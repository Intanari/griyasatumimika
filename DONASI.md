# 📖 Panduan Lengkap Fitur Donasi QRIS + Email – PeduliJiwa

Dokumentasi lengkap pembuatan fitur donasi dengan pembayaran QRIS (Midtrans) dan email terima kasih otomatis.

---

## 🗂️ Daftar Isi

1. [Spesifikasi Sistem](#spesifikasi-sistem)
2. [Struktur File yang Dibuat](#struktur-file-yang-dibuat)
3. [Alur Donasi](#alur-donasi)
4. [Langkah 1 — Install Package Midtrans](#langkah-1--install-package-midtrans)
5. [Langkah 2 — Buat Database Migration](#langkah-2--buat-database-migration)
6. [Langkah 3 — Buat Model Donation](#langkah-3--buat-model-donation)
7. [Langkah 4 — Buat Controller](#langkah-4--buat-controller)
8. [Langkah 5 — Buat Mailable (Email)](#langkah-5--buat-mailable-email)
9. [Langkah 6 — Buat Views](#langkah-6--buat-views)
10. [Langkah 7 — Daftarkan Routes](#langkah-7--daftarkan-routes)
11. [Langkah 8 — Update bootstrap/app.php](#langkah-8--update-bootstrapappphp)
12. [Langkah 9 — Konfigurasi .env](#langkah-9--konfigurasi-env)
13. [Langkah 10 — Konfigurasi config/services.php](#langkah-10--konfigurasi-configservicesphp)
14. [Langkah 11 — Jalankan Migration](#langkah-11--jalankan-migration)
15. [Langkah 12 — Perbaiki Permission](#langkah-12--perbaiki-permission)
16. [Langkah 13 — Update Tombol Donasi di Welcome Page](#langkah-13--update-tombol-donasi-di-welcome-page)
17. [Konfigurasi Midtrans](#konfigurasi-midtrans)
18. [Konfigurasi Email SMTP](#konfigurasi-email-smtp)
19. [Konfigurasi DNS untuk Email](#konfigurasi-dns-untuk-email)
20. [Test & Verifikasi](#test--verifikasi)
21. [Troubleshooting](#troubleshooting)

---

## Spesifikasi Sistem

| Komponen | Versi/Detail |
|---|---|
| OS | Ubuntu 24.04 (Noble) |
| PHP | 8.3.6 |
| Laravel | 12.x |
| Web Server | Nginx |
| Database | SQLite |
| SSL | Let's Encrypt (Certbot) |
| Domain | griyasatumimika.web.id |
| Payment Gateway | Midtrans (QRIS) |
| Email | SMTP (Gmail / Sumopod) |

---

## Struktur File yang Dibuat

```
my-laravel-app/
├── app/
│   ├── Http/Controllers/
│   │   └── DonationController.php       ← Controller utama donasi
│   ├── Mail/
│   │   └── DonationThankYou.php         ← Mailable email terima kasih
│   └── Models/
│       └── Donation.php                 ← Model donasi
├── bootstrap/
│   └── app.php                          ← Exclude CSRF untuk callback
├── config/
│   └── services.php                     ← Tambah konfigurasi Midtrans
├── database/
│   └── migrations/
│       └── 2026_03_02_..._create_donations_table.php
├── resources/views/
│   ├── welcome.blade.php                ← Landing page (tombol donasi diupdate)
│   ├── donation/
│   │   ├── form.blade.php               ← Halaman form isi data donatur
│   │   ├── payment.blade.php            ← Halaman QR Code QRIS
│   │   └── success.blade.php            ← Halaman sukses donasi
│   └── emails/donation/
│       └── thankyou.blade.php           ← Template email HTML
├── routes/
│   └── web.php                          ← Route donasi
└── .env                                 ← Konfigurasi Midtrans + SMTP
```

---

## Alur Donasi

```
Donatur klik "Donasi"
        ↓
[1] Halaman Form (/donasi?program=rawat-inap)
    - Isi: Nama, Email, Telepon, Jumlah, Pesan
        ↓
[2] Submit Form → DonationController@store
    - Simpan ke database
    - Kirim request ke Midtrans Core API (QRIS)
    - Dapat QR Code URL
        ↓
[3] Halaman Pembayaran QRIS (/donasi/{id}/bayar)
    - Tampil QR Code
    - Countdown timer 15 menit
    - Auto-check status setiap 5 detik
        ↓
[4] Donatur scan QR → Bayar via GoPay/OVO/Dana/dll
        ↓
[5] Midtrans kirim callback → DonationController@callback
    - Update status donasi = "paid"
    - Kirim email terima kasih ke donatur
        ↓
[6] Halaman Sukses (/donasi/{id}/sukses)
    - Tampil bukti donasi
    - Efek confetti
        ↓
[7] Email HTML cantik masuk ke inbox donatur
```

---

## Langkah 1 — Install Package Midtrans

```bash
cd /home/ubuntu/my-laravel-app
composer require midtrans/midtrans-php
```

---

## Langkah 2 — Buat Database Migration

```bash
php artisan make:migration create_donations_table
```

Edit file migration yang dibuat di `database/migrations/..._create_donations_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('program');
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone');
            $table->unsignedBigInteger('amount');
            $table->text('message')->nullable();
            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->string('qr_string', 1000)->nullable();
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
```

---

## Langkah 3 — Buat Model Donation

```bash
php artisan make:model Donation
```

Edit `app/Models/Donation.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'program', 'donor_name', 'donor_email', 'donor_phone',
        'amount', 'message', 'order_id', 'transaction_id',
        'qr_code_url', 'qr_string', 'status', 'paid_at',
    ];

    protected $casts = [
        'amount'  => 'integer',
        'paid_at' => 'datetime',
    ];

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
```

---

## Langkah 4 — Buat Controller

```bash
php artisan make:controller DonationController
```

Edit `app/Http/Controllers/DonationController.php` — berisi method:

| Method | URL | Fungsi |
|---|---|---|
| `showForm()` | GET `/donasi` | Tampilkan form donasi |
| `store()` | POST `/donasi` | Simpan & buat QRIS |
| `showPayment()` | GET `/donasi/{id}/bayar` | Tampilkan QR Code |
| `checkStatus()` | GET `/donasi/{id}/status` | Cek status (AJAX) |
| `callback()` | POST `/donasi/callback` | Webhook Midtrans |
| `success()` | GET `/donasi/{id}/sukses` | Halaman sukses |
| `sendThankYouEmail()` | — | Kirim email (private) |

---

## Langkah 5 — Buat Mailable (Email)

```bash
php artisan make:mail DonationThankYou --markdown=emails.donation.thankyou
```

Edit `app/Mail/DonationThankYou.php`:

```php
<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Donation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🙏 Terima Kasih atas Donasi Anda – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation.thankyou',
        );
    }
}
```

Template email HTML cantik ada di: `resources/views/emails/donation/thankyou.blade.php`

---

## Langkah 6 — Buat Views

```bash
mkdir -p resources/views/donation
mkdir -p resources/views/emails/donation
```

File views yang perlu dibuat:

| File | Keterangan |
|---|---|
| `resources/views/welcome.blade.php` | Landing page utama |
| `resources/views/donation/form.blade.php` | Form isi data donatur |
| `resources/views/donation/payment.blade.php` | Halaman QR QRIS |
| `resources/views/donation/success.blade.php` | Halaman sukses |
| `resources/views/emails/donation/thankyou.blade.php` | Email HTML |

---

## Langkah 7 — Daftarkan Routes

Edit `routes/web.php`:

```php
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

// Midtrans callback — CSRF dikecualikan di bootstrap/app.php
Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donation.callback');
```

---

## Langkah 8 — Update bootstrap/app.php

Kecualikan route callback Midtrans dari CSRF protection:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'donasi/callback',   // ← Midtrans webhook tidak pakai CSRF
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

---

## Langkah 9 — Konfigurasi .env

```bash
cp .env.example .env
php artisan key:generate
```

Tambahkan/edit nilai berikut di `.env`:

```env
APP_NAME=PeduliJiwa
APP_ENV=production
APP_DEBUG=false
APP_URL=https://griyasatumimika.web.id

# Database SQLite (default Laravel)
DB_CONNECTION=sqlite

# Email SMTP — opsi 1: Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"    # Google App Password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="emailkamu@gmail.com"
MAIL_FROM_NAME="PeduliJiwa"

# Email SMTP — opsi 2: Sumopod
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.sumopod.com
# MAIL_PORT=465
# MAIL_USERNAME=username_smtp_dari_sumopod
# MAIL_PASSWORD=password_smtp_dari_sumopod
# MAIL_ENCRYPTION=ssl
# MAIL_FROM_ADDRESS="donasi@griyasatumimika.web.id"
# MAIL_FROM_NAME="PeduliJiwa"

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false    # Ganti true saat go-live
```

---

## Langkah 10 — Konfigurasi config/services.php

Tambahkan blok Midtrans:

```php
'midtrans' => [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
],
```

---

## Langkah 11 — Jalankan Migration

```bash
php artisan migrate
```

Verifikasi:

```bash
php artisan migrate:status
```

Output yang diharapkan:

```
Migration name                                    Batch / Status
0001_01_01_000000_create_users_table              [1] Ran
0001_01_01_000001_create_cache_table              [1] Ran
0001_01_01_000002_create_jobs_table               [1] Ran
2026_03_02_..._create_donations_table             [2] Ran
```

---

## Langkah 12 — Perbaiki Permission

Jalankan setiap kali ada masalah **"Permission Denied"** atau **"readonly database"**:

```bash
# Permission storage & bootstrap/cache (untuk log, session, cache)
sudo chown -R www-data:ubuntu storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Permission database SQLite
sudo chown www-data:ubuntu database/database.sqlite
sudo chmod 664 database/database.sqlite
sudo chown www-data:ubuntu database/
sudo chmod 775 database/

# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## Langkah 13 — Update Tombol Donasi di Welcome Page

Ubah semua `href="#"` pada tombol donasi menjadi route Laravel:

```blade
{{-- Tombol hero --}}
<a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-hero-primary">
    ❤️ Donasi Sekarang
</a>

{{-- Program 1 --}}
<a href="{{ route('donation.form', ['program' => 'rawat-inap']) }}" class="btn-prog">Donasi</a>

{{-- Program 2 --}}
<a href="{{ route('donation.form', ['program' => 'pelatihan-vokasi']) }}" class="btn-prog">Donasi</a>

{{-- Program 3 --}}
<a href="{{ route('donation.form', ['program' => 'rumah-singgah']) }}" class="btn-prog">Donasi</a>

{{-- CTA Section --}}
<a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-cta-white">❤️ Donasi Sekarang</a>
```

---

## Konfigurasi Midtrans

### 1. Daftar Akun Midtrans
- Buka [dashboard.midtrans.com](https://dashboard.midtrans.com)
- Daftar akun baru (gratis)

### 2. Ambil API Keys (Sandbox untuk testing)
- Masuk ke **Settings → Access Keys**
- Salin **Server Key** dan **Client Key** (yang diawali `SB-` untuk sandbox)

### 3. Aktifkan QRIS
- Masuk ke **Settings → Payment Methods**
- Aktifkan **QRIS**

### 4. Konfigurasi Notification URL (Webhook)
- Masuk ke **Settings → Configuration**
- Isi **Payment Notification URL**:
  ```
  https://griyasatumimika.web.id/donasi/callback
  ```

### 5. Go Live ke Production
Saat sudah siap production, ubah di `.env`:
```env
MIDTRANS_SERVER_KEY=Mid-server-PRODUCTION_KEY
MIDTRANS_CLIENT_KEY=Mid-client-PRODUCTION_KEY
MIDTRANS_IS_PRODUCTION=true
```

---

## Konfigurasi Email SMTP

### Opsi A — Gmail (Paling Mudah)

1. Aktifkan **2-Factor Authentication** di akun Google
2. Buka [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
3. Buat **App Password** untuk "Mail"
4. Salin password 16 karakter (format: `xxxx xxxx xxxx xxxx`)
5. Isi di `.env`:

```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="emailkamu@gmail.com"
MAIL_FROM_NAME="PeduliJiwa"
```

### Opsi B — Sumopod

1. Login ke panel Sumopod
2. Buka menu **SMTP Credentials** → **Create New**
3. Salin username & password yang muncul (hanya tampil sekali!)
4. Isi di `.env`:

```env
MAIL_HOST=smtp.sumopod.com
MAIL_PORT=465
MAIL_USERNAME=username_dari_sumopod
MAIL_PASSWORD=password_dari_sumopod
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="donasi@griyasatumimika.web.id"
MAIL_FROM_NAME="PeduliJiwa"
```

### Test Kirim Email

```bash
cd /home/ubuntu/my-laravel-app
php artisan config:clear

# Test kirim email ke donatur terakhir
php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();

\$donation = App\Models\Donation::latest()->first();
Illuminate\Support\Facades\Mail::to(\$donation->donor_email)
    ->send(new App\Mail\DonationThankYou(\$donation));
echo 'EMAIL BERHASIL DIKIRIM!' . PHP_EOL;
"
```

---

## Konfigurasi DNS untuk Email

Tambahkan record berikut di panel DNS domain (Cloudflare/cPanel/registrar):

### DKIM (Tanda tangan email — anti spam)
| Type | Name | Value |
|---|---|---|
| TXT | `trx_ke._domainkey` | `v=DKIM1; k=rsa; p=...` |

### SPF (Otorisasi pengirim)
| Type | Name | Value |
|---|---|---|
| TXT | `@` | `v=spf1 mx include:spf.kirim.email ~all` |

### Verifikasi Sumopod
| Type | Name | Value |
|---|---|---|
| TXT | `@` | `sumo-verification=3d4e270d-...` |

> ⏱️ DNS butuh **5–30 menit** untuk propagasi. Setelah itu klik **Verify** di panel Sumopod.

---

## Test & Verifikasi

### Cek routes terdaftar
```bash
php artisan route:list
```

### Cek status migration
```bash
php artisan migrate:status
```

### Test koneksi Midtrans QRIS
```bash
php -r "
require 'vendor/autoload.php';
\Midtrans\Config::\$serverKey    = 'Mid-server-xxxxx';
\Midtrans\Config::\$isProduction = false;
\$params = [
    'payment_type' => 'qris',
    'transaction_details' => ['order_id' => 'TEST-' . time(), 'gross_amount' => 10000],
    'customer_details' => ['first_name' => 'Test', 'email' => 'test@test.com', 'phone' => '08123456789'],
    'item_details' => [['id' => 'test', 'price' => 10000, 'quantity' => 1, 'name' => 'Test Donasi']],
    'qris' => ['acquirer' => 'gopay'],
];
\$response = \Midtrans\CoreApi::charge(\$params);
echo 'STATUS: ' . \$response->status_code . PHP_EOL;
echo 'QR URL: ' . \$response->actions[0]->url . PHP_EOL;
"
```

### Cek log error
```bash
tail -50 storage/logs/laravel.log
```

### Clear semua cache
```bash
php artisan optimize:clear
```

---

## Troubleshooting

### ❌ Error: Permission Denied (storage/logs)
```bash
sudo chown -R www-data:ubuntu storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### ❌ Error: attempt to write a readonly database
```bash
sudo chown www-data:ubuntu database/database.sqlite database/
sudo chmod 664 database/database.sqlite
sudo chmod 775 database/
```

### ❌ Error: View [donation.form] not found
```bash
# Pastikan file view ada
ls resources/views/donation/
# Jika kosong, buat ulang file-file view

# Clear view cache
php artisan view:clear
```

### ❌ Error: bootstrap/app.php not found
```bash
# Buat ulang file bootstrap/app.php
# (lihat isi file di Langkah 8)
php artisan key:generate
```

### ❌ Error: 530 authentication Required (SMTP)
SMTP credentials kosong di `.env`. Isi `MAIL_USERNAME` dan `MAIL_PASSWORD`.

### ❌ Error: 535 Authentication failed (SMTP)
Password SMTP salah. Solusi:
- **Gmail**: Gunakan App Password 16 karakter, bukan password biasa
- **Sumopod**: Copy-paste credentials langsung dari panel, jangan screenshot

### ❌ QRIS tidak muncul (placeholder)
Midtrans credentials belum diisi. Pastikan `.env` memiliki:
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
```

### ❌ Callback Midtrans tidak berjalan
1. Pastikan URL callback di dashboard Midtrans sudah benar:
   `https://griyasatumimika.web.id/donasi/callback`
2. Pastikan route tidak di-block CSRF (sudah dikecualikan di `bootstrap/app.php`)

---

## 📋 Ringkasan Perintah Sehari-hari

```bash
# Masuk ke direktori project
cd /home/ubuntu/my-laravel-app

# Clear semua cache (jalankan setelah edit .env)
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Lihat log error terbaru
tail -100 storage/logs/laravel.log

# Lihat semua donasi di database
php artisan tinker
>>> App\Models\Donation::latest()->get(['id','donor_name','amount','status','created_at'])

# Fix permission (jika ada error permission)
sudo chown -R www-data:ubuntu storage bootstrap/cache database/
sudo chmod -R 775 storage bootstrap/cache
sudo chmod 664 database/database.sqlite

# Restart PHP-FPM (jika perlu)
sudo systemctl restart php8.3-fpm

# Reload Nginx
sudo systemctl reload nginx
```

---

## 🔗 URL Penting

| Halaman | URL |
|---|---|
| Beranda / Landing Page | `https://griyasatumimika.web.id` |
| Form Donasi (Umum) | `https://griyasatumimika.web.id/donasi?program=umum` |
| Form Donasi (Rawat Inap) | `https://griyasatumimika.web.id/donasi?program=rawat-inap` |
| Form Donasi (Pelatihan) | `https://griyasatumimika.web.id/donasi?program=pelatihan-vokasi` |
| Form Donasi (Rumah Singgah) | `https://griyasatumimika.web.id/donasi?program=rumah-singgah` |
| Dashboard Midtrans Sandbox | `https://dashboard.sandbox.midtrans.com` |
| Dashboard Midtrans Production | `https://dashboard.midtrans.com` |
| Google App Passwords | `https://myaccount.google.com/apppasswords` |

---

*Dibuat: Maret 2026 | PeduliJiwa – Rehabilitasi ODGJ Indonesia* 🧠💜
