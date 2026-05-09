# Struktur dan Narasi Bab II Landasan Teori

Dokumen ini merangkum **Bab II Landasan Teori** untuk skripsi atau laporan tugas akhir yang membahas sistem informasi berbasis web **Griya Satu Mimika**, dibangun dengan **Laravel 12**, **PHP 8.2**, basis data relasional, **Midtrans**, **Laravel Mail**, **DomPDF**, **Tailwind CSS**, dan **Vite**. Isi dapat disalin ke naskah utama dan dilengkapi kutipan dari sumber sekunder (buku, jurnal, dokumentasi resmi).

---

## BAB II LANDASAN TEORI

### 2.1 Sistem Informasi Berbasis Web

**Landasan teori**

Sistem informasi adalah kombinasi teknologi, manusia, dan prosedur yang mengumpulkan, memproses, menyimpan, dan menyebarkan informasi untuk mendukung pengambilan keputusan dan operasional organisasi. Aplikasi berbasis web menyajikan antarmuka melalui peramban (browser) sehingga pengguna tidak perlu menginstal perangkat lunak khusus di setiap perangkat; cukup mengakses URL melalui protokol HTTP atau HTTPS.

Organisasi sosial seperti yayasan membutuhkan kanal informasi yang transparan: profil lembaga, layanan, kontak, hingga laporan keuangan donasi. Sistem informasi web memungkinkan pemisahan akses antara **publik** (tanpa login) dan **pengelola** (dengan login) sesuai kebutuhan keamanan dan privasi data.

**Penerapan pada aplikasi**

Aplikasi ini menyediakan halaman publik di domain utama (mis. `griyasatumimika.web.id`) untuk beranda, profil, layanan, galeri, kontak, donasi, laporan ODGJ, transparansi donasi, dan daftar pasien publik. Pengelolaan data sensitif dilakukan melalui subdomain admin terpisah dengan autentikasi.

---

### 2.2 Arsitektur Client–Server dan Pola MVC

**Landasan teori**

Pada arsitektur **client–server**, klien (browser) mengirim permintaan HTTP; server memproses permintaan dan mengembalikan respons (HTML, redirect, file, atau JSON). Pola **Model–View–Controller (MVC)** memisahkan tanggung jawab: **Model** merepresentasikan data dan aturan bisnis; **View** menampilkan data ke pengguna; **Controller** menerima input, memanggil model, dan menentukan view atau respons yang dikembalikan.

Pemisahan ini meningkatkan keterbacaan kode, kemudahan pengujian, dan skalabilitas pengembangan tim.

**Penerapan pada aplikasi**

Framework Laravel menerapkan MVC: **Eloquent Model** untuk entitas seperti `Patient`, `Donation`, `OdgjReport`; **Controller** di `app/Http/Controllers` menangani logika permintaan; **Blade** di `resources/views` sebagai lapisan tampilan.

---

### 2.3 Bahasa Pemrograman PHP dan Manajemen Dependensi Composer

**Landasan teori**

PHP (*Hypertext Preprocessor*) adalah bahasa pemrograman server-side yang dieksekusi di sisi server dan menghasilkan HTML atau respons lain ke klien. Versi modern PHP menawarkan sistem tipe yang lebih ketat, performa yang diperbaiki, dan ekosistem paket yang luas.

**Composer** adalah manajer dependensi untuk PHP; berkas `composer.json` mendefinisikan paket yang dibutuhkan, dan autoload PSR-4 memetakan namespace ke direktori `app/`.

**Penerapan pada aplikasi**

Proyek mensyaratkan **PHP ^8.2**. Dependensi produksi antara lain `laravel/framework`, `midtrans/midtrans-php`, dan `barryvdh/laravel-dompdf`. Perintah `composer install` dan skrip `setup` di `composer.json` mendukung instalasi lingkungan pengembangan.

---

### 2.4 Framework Laravel

**Landasan teori**

Laravel adalah framework aplikasi web PHP yang menyediakan abstraksi untuk routing, ORM, migrasi, autentikasi, validasi, mail, file storage, dan lainnya. Konsep inti meliputi **service container** untuk injeksi dependensi, **facade** sebagai antarmuka statis ke layanan terdaftar, dan **Artisan** sebagai antarmuka baris perintah.

Versi Laravel yang dipakai mengikuti siklus rilis framework (proyek ini: **Laravel 12**).

**Penerapan pada aplikasi**

Konfigurasi aplikasi di `config/` dan `.env`; bootstrap aplikasi di `bootstrap/app.php`; rute web di `routes/web.php`; model di `app/Models`; perintah kustom dan penjadwalan di `app/Console/`.

---

### 2.5 Routing HTTP dan Middleware

**Landasan teori**

**Routing** memetakan URL dan metode HTTP ke aksi controller atau closure. Penamaan rute (*named routes*) memudahkan pembuatan URL dan redirect yang konsisten. **Middleware** adalah lapisan filter yang dijalankan sebelum atau sesudah request mencapai controller, misalnya untuk autentikasi, otorisasi, atau pembatasan tamu.

**Penerapan pada aplikasi**

- Rute dikelompokkan dengan **`Route::domain()`** untuk memisahkan **domain utama** (publik) dan **domain admin** (`config('app.admin_domain')` dan `config('app.main_domain')`).
- Middleware **`auth`** melindungi dashboard; **`guest`** membatasi halaman login/register hanya untuk pengguna belum login.
- **CSRF validation** dikonfigurasi dengan pengecualian untuk `donasi/callback` agar webhook **Midtrans** dapat mem-post notifikasi tanpa token CSRF (endpoint khusus server-to-server yang harus diverifikasi dengan mekanisme Midtrans).

---

### 2.6 Mesin Template Blade

**Landasan teori**

Blade adalah mesin template Laravel yang mengompilasi template menjadi kode PHP biasa. Blade mendukung pewarisan layout, komponen, direktif kondisi dan perulangan, serta escaping otomatis untuk mengurangi risiko XSS pada output teks.

Form HTML yang mengubah state server sebaiknya menyertakan token **CSRF** (`@csrf`).

**Penerapan pada aplikasi**

View publik di `resources/views/public/`, dashboard di `resources/views/dashboard/`, email di `resources/views/emails/`. Aset frontend dihubungkan dengan `@vite` untuk CSS dan JS.

---

### 2.7 Basis Data Relasional dan Migrasi Skema

**Landasan teori**

Basis data **relasional** menyimpan data dalam tabel yang dihubungkan dengan kunci primer dan asing. **Normalisasi** mengurangi redundansi dan anomali pembaruan. **Migrasi** adalah skrip versi skema yang dapat dijalankan berulang di lingkungan berbeda sehingga struktur database konsisten dengan kode aplikasi.

**Penerapan pada aplikasi**

Migrasi di `database/migrations/` antara lain: `users` (dengan perluasan field petugas dan role), `patients`, `patient_schedules`, `patient_activities`, `examination_histories`, `rehabilitation_schedules`, `jadwal_petugas`, `shifts`, `donations`, `donation_expenses`, `inventory_items`, `stock_transactions`, `stock_supplies`, `stock_expenses`, `odgj_reports`, `web_settings`, konten profil (`profil_yayasan`, `visi_misi`, `struktur_kepengurusan`, `petugas_yayasan`, `proses_laporan_odgj`, `tahapan_rehabilitasi`), serta tabel bawaan Laravel untuk cache, jobs, dan sesi sesuai kebutuhan.

---

### 2.8 Eloquent ORM dan Relasi Data

**Landasan teori**

**Object-Relational Mapping (ORM)** memetakan baris tabel ke objek PHP. Eloquent menyediakan API untuk CRUD, relasi (`hasMany`, `belongsTo`, dll.), *query scope*, dan *eager loading* (`with()`) untuk mengurangi jumlah query N+1.

**Penerapan pada aplikasi**

Model Eloquent menghubungkan entitas bisnis: pasien dengan jadwal dan aktivitas; donasi dengan status pembayaran; laporan ODGJ dengan alur persetujuan admin; stok dengan transaksi dan persediaan. Query di controller memfilter, mencari, dan mengurutkan data untuk tabel dashboard dan halaman publik (mis. galeri dari `PatientActivity` yang memiliki gambar).

---

### 2.9 Autentikasi, Sesi, dan Otorisasi Berbasis Peran

**Landasan teori**

**Autentikasi** memverifikasi identitas pengguna (biasanya email/username dan password). **Sesi** menyimpan status login di server (atau token di aplikasi API). Password disimpan dengan **hash** satu arah (mis. bcrypt). **Otorisasi** menentukan apakah pengguna yang sudah login diizinkan mengakses fitur tertentu (peran/admin).

**Penerapan pada aplikasi**

Login dan register di subdomain admin; rute dashboard dibungkus middleware `auth`. Model `User` memiliki field peran (`role`) dan atribut petugas; controller memanggil pengecekan seperti `ensureAdminOrManager()` pada modul yang dibatasi. Logout meminvalidate sesi.

---

### 2.10 Keamanan Aplikasi Web

**Landasan teori**

- **Cross-Site Request Forgery (CSRF):** memaksa pengguna terautentikasi mengirim permintaan tidak disengaja; Laravel memverifikasi token pada permintaan state-changing.
- **Validasi input:** mencegah data tidak valid dan serangan injeksi terkait; Laravel menyediakan rule validasi deklaratif.
- **XSS:** membatasi output yang mengandung HTML dari pengguna; Blade meng-escape secara default.
- **Upload file:** membatasi tipe dan ukuran, menyimpan di luar web root atau melalui disk yang dikonfigurasi, dan tidak mempercayai nama file mentah.

**Penerapan pada aplikasi**

Validasi pada form donasi, laporan ODGJ, CRUD pasien, jadwal, stok, dan pengaturan. Penyimpanan foto/fail melalui `Storage` disk `public`. Pengecualian CSRF hanya pada callback Midtrans dengan asumsi verifikasi tanda tangan/notifikasi dari gateway.

---

### 2.11 HTML5, CSS, dan Tailwind CSS

**Landasan teori**

HTML5 menyediakan struktur semantik dokumen web. **CSS** mengatur tata letak dan gaya. **Tailwind CSS** adalah kerangka *utility-first*: kelas kecil dikombinasikan di markup untuk menghasilkan desain konsisten tanpa menulis banyak CSS kustom.

**Penerapan pada aplikasi**

Proyek memakai **Tailwind CSS v4** dengan plugin **`@tailwindcss/vite`** di `vite.config.js`. Entry stylesheet: `resources/css/app.css`.

---

### 2.12 Vite, Laravel Vite Plugin, dan Axios

**Landasan teori**

**Vite** adalah bundler frontend yang cepat untuk pengembangan (HMR) dan build produksi. **laravel-vite-plugin** menyelaraskan path build dengan helper `@vite` di Blade. **Axios** adalah klien HTTP berbasis promise untuk JavaScript, umum dipakai untuk AJAX ke endpoint Laravel.

**Penerapan pada aplikasi**

`npm run dev` / `npm run build`; input `resources/css/app.css` dan `resources/js/app.js`. `resources/js/bootstrap.js` mengimpor Axios dan mengatur header `X-Requested-With: XMLHttpRequest` untuk kompatibilitas dengan Laravel.

---

### 2.13 Payment Gateway, Midtrans, dan Alur Pembayaran Donasi

**Landasan teori**

**Payment gateway** adalah layanan pihak ketiga yang memproses pembayaran digital antara pembeli/donatur, merchant (yayasan), dan jaringan pembayaran. Alur umum: pembuatan **order** / **charge**, tampilan instruksi pembayaran (mis. **QRIS**), konfirmasi status melalui **callback** server-to-server dan/atau pengecekan status transaksi.

**Penerapan pada aplikasi**

Paket **`midtrans/midtrans-php`**: konfigurasi kunci server dan mode sandbox/production; `DonationController` membuat transaksi, menampilkan halaman pembayaran, memeriksa status, menangani **callback** POST di rute `donasi/callback`, dan mengirim email ucapan terima kasih setelah donasi sukses. Integrasi mengacu pada dokumentasi Midtrans (Core API, notifikasi pembayaran).

---

### 2.14 Laravel Mail dan Notifikasi Email

**Landasan teori**

Email transaksional menginformasikan pengguna tentang peristiwa penting (konfirmasi donasi, status laporan, jadwal). Laravel **Mail** mendukung **Mailable** class, antrian (opsional), dan konfigurasi SMTP di `.env`.

**Penerapan pada aplikasi**

`Mail::to(...)->send(...)` dipakai di berbagai controller: notifikasi laporan ODGJ ke petugas dan email ke warga; notifikasi data pasien, petugas, jadwal rehabilitasi, jadwal pasien, jadwal petugas, riwayat pemeriksaan, stok; perintah `SendPatientScheduleReminders` mengirim pengingat ke pembimbing. Template email berada di `resources/views/emails/`.

---

### 2.15 Pembuatan PDF dengan DomPDF (barryvdh/laravel-dompdf)

**Landasan teori**

**PDF** adalah format dokumen tetap yang cocok untuk cetak dan unduhan resmi. **DomPDF** merender HTML/CSS menjadi PDF. Paket **barryvdh/laravel-dompdf** mengintegrasikan DomPDF ke Laravel melalui facade `Pdf`.

**Penerapan pada aplikasi**

`Pdf::loadView()` digunakan untuk laporan **transparansi donasi** (donasi dan pengeluaran), ekspor **jadwal rehabilitasi**, dan ekspor **jadwal petugas**. View Blade khusus ekspor memuat tabel dan gaya cetak.

---

### 2.16 Ekspor Data Tabular (CSV dan Streamed Response)

**Landasan teori**

**CSV** (*Comma-Separated Values*) adalah format teks sederhana untuk pertukaran data tabular; dapat dibuka di spreadsheet. **Streamed response** mengirim data bertahap ke klien sehingga memori server tidak memuat seluruh file sekaligus untuk dataset besar.

**Penerapan pada aplikasi**

`PetugasController::exportExcel` (nama fitur “Excel”) menghasilkan **CSV** dengan `StreamedResponse` dan `fputcsv`, header `Content-Type: text/csv; charset=UTF-8`. Modul stok menyediakan ekspor CSV sesuai rute yang didefinisikan.

---

### 2.17 Penyimpanan Berkas (Laravel Storage)

**Landasan teori**

Aplikasi web sering menyimpan unggahan gambar/dokumen di disk yang dapat diakses publik atau privat. Laravel **Filesystem** menyediakan abstraksi disk (`local`, `public`, S3, dll.) dan helper `Storage::`.

**Penerapan pada aplikasi**

Foto pasien, petugas, atau aktivitas disimpan di disk **`public`** dengan path relatif yang disimpan di database; penghapusan entitas dapat disertai penghapusan file agar tidak menumpuk sampah storage.

---

### 2.18 Konten Dinamis Situs Publik dan Pengaturan Web

**Landasan teori**

**Content management** ringan memungkinkan non-programmer memperbarui teks, urutan, dan tampilan melalui panel admin. Pengaturan tema (warna, latar) dapat disimpan di basis data dan diinjeksikan ke view.

**Penerapan pada aplikasi**

Model seperti `WebSetting`, `ProfilYayasan`, `VisiMisi`, `StrukturKepengurusan`, `PetugasYayasan`, `ProsesLaporanOdgj`, dan `TahapanRehabilitasi` mengisi halaman publik `/profil/*`, `/layanan`, dan pengaturan warna melalui `WebSettingController`.

---

### 2.19 Ringkasan Domain Bisnis Sistem (Landasan Konseptual)

Secara konseptual, subsistem aplikasi meliputi:

| Subsistem | Fungsi utama |
|-----------|----------------|
| **Publik & profil** | Informasi yayasan, layanan, galeri aktivitas pasien, kontak |
| **Donasi** | Form donasi, pembayaran Midtrans/QRIS, callback, email, transparansi |
| **Laporan ODGJ** | Form warga, notifikasi petugas, verifikasi/respon admin, email status |
| **Pasien** | Data pasien, jadwal kunjungan, aktivitas, riwayat pemeriksaan |
| **Rehabilitasi & petugas** | Jadwal rehabilitasi, shift, jadwal jaga, libur/ganti shift, ekspor PDF |
| **Stok** | Barang, transaksi, persediaan, pengeluaran, peringatan email |
| **Administrasi** | Manajemen user admin/petugas, pengaturan web |

Teori **alur kerja (workflow)** dan **status transaksi** relevan untuk donasi dan laporan ODGJ (mis. pending, diterima, ditolak, dengan respon).

---

### 2.20 Penjadwalan Tugas (Task Scheduling) dan Perintah Artisan

**Landasan teori**

Laravel **Scheduler** menjalankan perintah Artisan pada interval waktu. Server produksi menjalankan `* * * * * php artisan schedule:run` melalui cron. Ini memisahkan tugas periodik dari permintaan HTTP pengguna.

**Penerapan pada aplikasi**

`app/Console/Kernel.php` menjadwalkan perintah `patient-schedule:send-reminders` (setiap menit sesuai konfigurasi saat ini—dapat disesuaikan ke interval yang lebih longgar di produksi). Perintah mengirim email pengingat jadwal pasien berdasarkan logika di `SendPatientScheduleReminders`.

---

### 2.21 Kualitas Perangkat Lunak dan Pengujian

**Landasan teori**

Kualitas perangkat lunak mencakup kebenaran fungsional, keamanan, pemeliharaan, dan dokumentasi. **Pengujian otomatis** (unit/feature) membantu regresi saat fitur bertambah. Laravel menyediakan `php artisan test` dan PHPUnit (lihat `composer.json`).

**Penerapan pada aplikasi**

Tim pengembang dapat menambah tes di `tests/`; praktik **logging** (`Log::error`) pada kegagalan pengiriman email mendukung diagnosis operasional.

---

### 2.22 Kerangka Kerja Scrum

**Landasan teori**

**Scrum** adalah kerangka kerja Agile untuk mengembangkan produk kompleks secara iteratif dan inkremental. Komponen utamanya: **peran** (Product Owner, Scrum Master, Developers), **artefak** (*product backlog*, *sprint backlog*, *increment*), dan **acara** (*sprint*, *sprint planning*, *daily scrum*, *sprint review*, *sprint retrospective*). Definisi dan aturan resmi dijabarkan dalam *The Scrum Guide* (Schwaber & Sutherland, 2020). Prinsip Agile (manifes Agile) menjelaskan nilai-nilai yang sejalan dengan Scrum (Beck et al., 2001).

**Kaitan dengan metode penelitian (Bab III)**

Penelitian memakai Scrum sebagai metode pengembangan: kebutuhan dari wawancara masuk ke *product backlog*, pekerjaan dipecah per *sprint* (durasi tetap), hasil akhir *sprint* berupa *increment* yang dapat diuji dan direview bersama pengurus yayasan. Penyesuaian peran untuk skripsi (satu developer, Product Owner dari yayasan) dijelaskan di Bab III agar tetap jujur secara metodologis.

---

### 2.23 Penutup Bab II

Bab ini telah menjelaskan teori dari sistem informasi web, arsitektur MVC, stack teknologi Laravel, basis data, keamanan, antarmuka pengguna, integrasi pembayaran dan email, PDF, ekspor data, storage, konten dinamis, domain bisnis, penjadwalan tugas, aspek kualitas, serta **Scrum** sebagai landasan metode pengembangan. Bab berikutnya (metode penelitian / analisis dan perancangan) akan menghubungkan landasan ini dengan analisis kebutuhan, perancangan basis data, dan implementasi modul pada sistem nyata.

---

## Daftar topik untuk pencarian referensi akademik

- Sistem informasi manajemen & sistem informasi berbasis web  
- Arsitektur client–server dan REST (jika diperlukan perbandingan)  
- Kerangka kerja Scrum dan Agile (*The Scrum Guide*, manifes Agile, literatur sekunder)  
- Dokumentasi resmi: Laravel, PHP, Tailwind CSS, Vite, Midtrans  
- Keamanan web: OWASP (CSRF, XSS, validasi input)  
- Payment gateway & e-donation  
- ORM dan desain basis data relasional  

---

*Dokumen ini disusun sesuai struktur kode repositori Laravel proyek Griya Satu Mimika. Perbarui contoh domain, nama paket, atau interval scheduler jika konfigurasi deployment berubah.*
