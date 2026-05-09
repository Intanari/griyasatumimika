# Product Backlog - Sistem Informasi Yayasan Griya Satu Mimika

## Konteks & Ruang Lingkup
Sistem menyediakan layanan publik dan dashboard admin terpisah melalui domain (publik vs admin). Modul utama:
1. CMS & Konten Publik (profil yayasan, visi-misi, struktur organisasi, layanan, galeri, pengaturan tampilan web).
2. Laporan ODGJ (form publik, notifikasi email, workflow verifikasi/tindak lanjut).
3. Donasi QRIS via Midtrans (form donasi, pembayaran, webhook callback, notifikasi email).
4. Transparansi Donasi (publikasi data donasi/pengeluaran dan ekspor PDF).
5. Manajemen Data Operasional (pasien, jadwal pasien + pengingat email, aktivitas pasien, riwayat pemeriksaan).
6. Penjadwalan Rehabilitasi & Petugas (jadwal rehabilitasi, jadwal petugas berbasis shift, libur/ganti shift, ekspor PDF).
7. Manajemen Stok & Inventori (persediaan, pengeluaran, transaksi in/out, notifikasi stok hampir habis/habis, ekspor CSV).

## Asumsi Scrum
- Durasi sprint: ~2 minggu.
- Product Owner: perwakilan yayasan (menentukan prioritas kebutuhan).
- Scrum Master: peneliti/PM (memastikan proses sprint berjalan).
- Definition of Done (DoD) ringkas per item:
  1. Fitur berjalan end-to-end (UI, validasi input, alur status jika ada).
  2. Notifikasi email/PDF (jika termasuk scope item) mengirim output yang benar.
  3. Minimal ada pengujian fungsional (black-box manual) atau test otomatis sesuai kesiapan proyek.
- Definition of Ready (DoR) ringkas:
  1. User story jelas, ada kriteria penerimaan, dan data yang dibutuhkan diketahui.
  2. Dependensi eksternal (Midtrans/SMTP) punya asumsi konfigurasi (sandbox/production) yang terdefinisi.

## Legenda Prioritas
- `Must (M)`: wajib untuk berjalan pada rilis MVP.
- `Should (S)`: penting untuk kualitas layanan.
- `Could (C)`: peningkatan kenyamanan/performa.
- `Won't (W)`: tidak dikerjakan pada iterasi ini.

## Target Sprint (Contoh)
- Sprint 0: Fondasi & Keamanan
- Sprint 1: CMS & Konten Publik + Web Settings
- Sprint 2: Laporan ODGJ Workflow
- Sprint 3: Donasi QRIS Midtrans + Transparansi Donasi
- Sprint 4: Manajemen Pasien (CRUD) + Aktivitas + Riwayat Pemeriksaan + Jadwal Pasien
- Sprint 5: Penjadwalan Rehabilitasi & Petugas + Stok & Inventori
- Sprint 6: Hardening, Testing, dan Perbaikan UX

---

## PB-001 Domain Routing Publik vs Admin
- Epic: Fondasi & Keamanan
- User story: Sebagai pengelola sistem, saya ingin domain publik dan admin terpisah agar akses konten sensitif terlindungi.
- Deskripsi: Menyiapkan `Route::domain(mainDomain)` untuk publik dan `Route::domain(adminDomain)` untuk autentikasi/dasbor.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Semua endpoint publik hanya bisa diakses via domain publik.
  2. Semua endpoint dashboard hanya bisa diakses via domain admin.
  3. Akses admin tanpa login mengarah ke halaman login.
- Dependensi: konfigurasi `config('app.main_domain')` dan `config('app.admin_domain')`.

---
## PB-002 Auth Login Admin
- Epic: Fondasi & Keamanan
- User story: Sebagai admin/petugas, saya ingin dapat login ke dashboard admin.
- Deskripsi: Implementasi halaman login dan endpoint `POST /login`.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Username/email dan password tervalidasi.
  2. Login sukses membawa ke halaman `dashboard`.
  3. Gagal login menampilkan pesan error yang jelas tanpa kebocoran detail.
- Dependensi: model `User` dan tabel `users`.

---
## PB-003 Auth Register Admin (opsional sesuai kebutuhan yayasan)
- Epic: Fondasi & Keamanan
- User story: Sebagai admin, saya ingin mendaftarkan akun petugas/admin sesuai prosedur internal.
- Deskripsi: endpoint guest-only untuk register.
- Prioritas: `Should (S)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Register tidak mengizinkan user yang sudah login.
  2. Password terenkripsi dan tersimpan aman.
  3. Validasi field wajib (email unik).
- Dependensi: migrasi `users`.

---
## PB-004 Middleware `auth` & `guest` untuk Admin Area
- Epic: Fondasi & Keamanan
- User story: Sebagai sistem, saya ingin memastikan halaman admin hanya untuk sesi login valid.
- Deskripsi: Menyiapkan group route `middleware('guest')` dan `middleware('auth')`.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Halaman dashboard memerlukan login.
  2. Halaman login/register tidak dapat diakses oleh user terautentikasi.
  3. Logout memvalidasi sesi dan mengalihkan sesuai kebutuhan.

---
## PB-005 Role-Based Access Control (RBAC) berbasis `users.role`
- Epic: Fondasi & Keamanan
- User story: Sebagai admin, saya ingin akses fitur sesuai peran agar data tidak disalahgunakan.
- Deskripsi: Menggunakan role (`admin`, `manajer`, `petugas_rehabilitasi`) pada gating controller.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Fitur manajemen user hanya dapat diakses role admin/superadmin sesuai aturan proyek.
  2. Fitur operasional dibatasi pada role yang memang berwenang.
  3. Upaya akses tanpa izin menerima respons `403`/redirect sesuai standar proyek.
- Dependensi: implementasi metode helper seperti `ensureAdmin()` pada controller.

---
## PB-006 Manajemen Akun Admin/Petugas (CRUD)
- Epic: Fondasi & Keamanan
- User story: Sebagai admin, saya ingin membuat, mengubah, menonaktifkan akun petugas.
- Deskripsi: CRUD user admin/petugas termasuk update role.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Admin dapat menambah user dengan role yang valid.
  2. Admin dapat mengubah role dan memodifikasi profil (mis. nama, jabatan, no HP jika ada).
  3. Admin dapat melakukan hapus akun (atau nonaktif bila kebijakan melarang delete).
- Dependensi: role constants pada `User`.

---
## PB-007 Update Password User Admin
- Epic: Fondasi & Keamanan
- User story: Sebagai pengguna admin, saya ingin memperbarui password saya.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Validasi password baru (mis. minimal length) dan konfirmasi jika diterapkan.
  2. Password tersimpan menggunakan hash.
  3. Setelah update, sesi tetap valid sesuai ketentuan (atau logout).

---
## PB-008 Keamanan Midtrans Callback dari CSRF
- Epic: Fondasi & Keamanan
- User story: Sebagai sistem pembayaran, saya ingin callback Midtrans dapat memproses webhook tanpa gagal CSRF.
- Deskripsi: Mengecualikan endpoint callback dari validasi CSRF.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Endpoint callback dapat menerima request server-to-server.
  2. Token CSRF tidak menyebabkan error 419 pada callback.
  3. Semua endpoint pembayaran lain tetap dilindungi CSRF.
- Dependensi: konfigurasi middleware CSRF exception.

---
## PB-009 Validasi Input Menyeluruh per Form
- Epic: Fondasi & Keamanan
- User story: Sebagai sistem, saya ingin memvalidasi data input untuk mencegah data rusak dan serangan.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Form donasi, laporan ODGJ, CRUD pasien, jadwal, aktivitas, riwayat pemeriksaan, stok memiliki aturan validasi.
  2. Upload file hanya menerima tipe yang diizinkan.
  3. Pesan error user-friendly.

---
## PB-010 Sanitasi & Proteksi Upload File
- Epic: Fondasi & Keamanan
- User story: Sebagai admin, saya ingin upload foto/bukti aman dan tidak merusak sistem.
- Deskripsi: Batasi ukuran, tipe mime, dan simpan menggunakan disk `public` + path di DB.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Foto pasien maksimal ukuran yang diset (contoh: 2 MB) dan format yang diset.
  2. Gambar laporan ODGJ maksimal 5 MB dan format yang diset.
  3. Bila file terganti/hapus, sistem menghapus file lama sesuai kebijakan.

---
## PB-011 Penanganan Error Eksternal (Midtrans/SMTP)
- Epic: Fondasi & Keamanan
- User story: Sebagai sistem, saya ingin error layanan eksternal tidak merusak alur utama.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Error pengiriman email dibatasi (log) tanpa mengubah status pembayaran yang sudah diproses.
  2. Gagal status-check Midtrans tidak mengubah data secara tidak konsisten.
  3. Callback Midtrans mengembalikan respons JSON `OK` bila proses sukses.

---
## PB-012 Observability Dasar (Logging)
- Epic: Fondasi & Keamanan
- User story: Sebagai pengembang, saya ingin error tercatat untuk investigasi cepat.
- Prioritas: `Should (S)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Error pada pengiriman email dan proses integrasi dicatat via logger.
  2. Log memuat konteks minimal (id transaksi/laporan/jadwal).
  3. Tidak ada data sensitif lengkap di log (mis. token rahasia).

---

## PB-013 CMS: Halaman Profil Yayasan (CRUD konten)
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengelola konten profil yayasan.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Admin dapat menambah/ubah/hapus item profil yayasan.
  2. Halaman publik `/profil/yayasan` menampilkan konten terbaru.
  3. Validasi judul/keterangan berjalan.

---
## PB-014 CMS: Visi-Misi (CRUD)
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengelola visi dan misi yayasan.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Admin dapat CRUD entitas `visi_misi`.
  2. Halaman publik `/profil/visi-misi` menampilkan data terurut.
  3. Tidak ada konten kosong yang merusak layout.

---
## PB-015 CMS: Struktur Organisasi (CRUD + Foto Petugas)
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengatur struktur kepengurusan dan foto tiap peran.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Admin dapat menyimpan foto (mimes/image) untuk tiap role kepengurusan.
  2. Urutan tampilan mengikuti aturan mapping `ROLES`/sorting.
  3. Halaman publik `/profil/struktur-organisasi` menampilkan nama, status, keterangan, dan foto.

---
## PB-016 CMS: Petugas Yayasan (CRUD anggota struktur operasional)
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengelola daftar petugas yayasan untuk ditampilkan.
- Prioritas: `Should (S)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Admin dapat menambah/mengubah/menghapus entitas petugas.
  2. Foto petugas disimpan dan tampil di publik.
  3. Urutan petugas konsisten berdasarkan `urutan`.

---
## PB-017 CMS: Layanan Publik (tahapan proses & langkah)
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengatur daftar proses laporan ODGJ dan tahapan rehabilitasi yang ditampilkan.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Admin dapat CRUD `proses_laporan_odgj` (no_urut, judul, keterangan).
  2. Admin dapat CRUD `tahapan_rehabilitasi` (no_urut, status, judul, keterangan).
  3. Halaman publik `/layanan` menampilkan kedua daftar tersebut terurut.

---
## PB-018 Web Settings: Warna Heading (h1-h6) + Paragraf + Span
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengubah warna elemen teks di halaman web tanpa ubah kode.
- Prioritas: `Should (S)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Admin dapat menyimpan nilai `h1_color`..`h6_color`, `p_color`, `span_color`.
  2. Perubahan tercermin pada halaman publik.
  3. Input dibatasi length dan disanitasi class name/color list.

---
## PB-019 Web Settings: Warna Div/A Element + Warna Button
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin mengubah warna elemen layout (div, link, button) agar branding sesuai.
- Prioritas: `Should (S)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Admin dapat menyimpan konfigurasi warna per class.
  2. Halaman publik menampilkan tampilan sesuai konfigurasi tersimpan.
  3. Tidak ada class injection melalui sanitasi class name (hanya karakter yang diizinkan).

---
## PB-020 Web Settings: Background Global vs Per Halaman
- Epic: CMS & Konten Publik
- User story: Sebagai admin, saya ingin menentukan background global atau berbeda per halaman.
- Prioritas: `Should (S)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Tipe background mendukung mode `warna` dan `gambar`.
  2. Mode gambar global menyimpan file dan menghapus file lama saat update.
  3. Mode per halaman menyimpan background berbeda sesuai slug halaman publik.
  4. Overlay opacity tersimpan dan diterapkan konsisten.

---
## PB-021 Halaman Publik: Beranda + CTA Donasi
- Epic: CMS & Konten Publik
- User story: Sebagai pengunjung publik, saya ingin melihat CTA untuk donasi yang mengarah ke form sesuai program.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Tombol donasi mengarah ke `donation.form` (domain publik).
  2. Program yang dipilih sesuai slug program (contoh rawat-inap, rumah-singgah, dll).
  3. Halaman tetap tampil walau data program dinamis.

---
## PB-022 Halaman Publik: Galeri Aktivitas Pasien (menggunakan image filter)
- Epic: CMS & Konten Publik
- User story: Sebagai pengunjung publik, saya ingin melihat bukti kegiatan melalui galeri.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Galeri memuat item aktivitas pasien yang memiliki `image` non-null/non-empty.
  2. Galeri menampilkan data terurut berdasarkan tanggal.
  3. Klik item menampilkan detail (jika implementasi view detail tersedia).
- Dependensi: data `patient_activities.image`.

---
## PB-023 Halaman Publik: Kontak, Cara Donasi, Mitra, FAQ
- Epic: CMS & Konten Publik
- User story: Sebagai pengunjung, saya ingin menemukan informasi tata cara donasi dan FAQ.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Halaman dapat diakses tanpa autentikasi.
  2. Routing publik mengarah ke view yang benar.
  3. Konten tidak error saat data tertentu kosong.

---
## PB-024 Publik: Profil Yayasan/Struktur sesuai data terbaru
- Epic: CMS & Konten Publik
- User story: Sebagai pengunjung, saya ingin melihat data profil terbaru setelah admin memperbarui.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Halaman publik membaca data dari tabel terkait.
  2. Urutan/penggabungan data konsisten (mis. struktur organisasi).
  3. Tidak terjadi error N+1 yang signifikan pada profil.

---

## PB-025 Laporan ODGJ: Form Publik (upload gambar + lokasi + kategori + email/kontak)
- Epic: Laporan ODGJ Workflow
- User story: Sebagai warga, saya ingin mengirim laporan ODGJ lewat form publik agar petugas segera menindaklanjuti.
- Deskripsi: Endpoint `GET /laporan-odgj` + `POST /laporan-odgj`.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Kategori hanya menerima `penjemputan` atau `pengantaran`.
  2. Validasi gambar (mimes jpeg/jpg/png/webp, max ukuran) dan field wajib terpenuhi.
  3. Laporan tersimpan dengan `nomor_laporan` otomatis berformat `ODGJ-XXXXXX-YYYYMMDD`.
  4. Upload file tersimpan di disk `public` dan path tersimpan di DB.

---
## PB-026 Laporan ODGJ: Status Awal “baru”
- Epic: Laporan ODGJ Workflow
- User story: Sebagai sistem, saya ingin setiap laporan baru memiliki status awal yang jelas.
- Prioritas: `Must (M)`
- Estimasi: 1 SP
- Acceptance criteria:
  1. Laporan dibuat dengan status default `baru`.
  2. Dashboard menampilkan laporan baru di daftar.

---
## PB-027 Notifikasi Email ke Petugas saat Laporan Masuk
- Epic: Laporan ODGJ Workflow
- User story: Sebagai petugas, saya ingin menerima email saat ada laporan ODGJ baru.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Email dikirim ke semua user role `petugas_rehabilitasi` yang aktif.
  2. Jika petugas kosong/tidak punya email, sistem tidak error (log boleh ada).
  3. Template email memuat informasi inti laporan (kategori, lokasi, deskripsi, nomor laporan).
- Dependensi: mail configuration (`.env`) SMTP.

---
## PB-028 Email Terima Kasih ke Pelapor/Warga
- Epic: Laporan ODGJ Workflow
- User story: Sebagai warga, saya ingin menerima email terima kasih setelah laporan terkirim.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Email hanya dikirim jika field `email` pada laporan tidak kosong.
  2. Konten email memuat nomor laporan dan ringkasan.
  3. Kegagalan kirim tidak memblokir pembuatan laporan.

---
## PB-029 Admin: Daftar Laporan ODGJ & Filter/Paginasi
- Epic: Laporan ODGJ Workflow
- User story: Sebagai admin, saya ingin melihat daftar laporan ODGJ untuk ditindaklanjuti.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Halaman dashboard menampilkan list laporan terurut terbaru.
  2. Paginasi berjalan.
  3. Dashboard menampilkan statistik ringkas (jumlah laporan, status, kategori) sesuai query.

---
## PB-030 Admin: Terima Laporan (status -> diproses + email konfirmasi)
- Epic: Laporan ODGJ Workflow
- User story: Sebagai admin, saya ingin menerima laporan agar status menjadi diproses dan pelapor mendapat konfirmasi.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Aksi `terima` mengubah status laporan menjadi `diproses`.
  2. Email ke pelapor dikirim jika `laporan.email` ada.
  3. UI memberi feedback success/error yang jelas.

---
## PB-031 Admin: Tolak Laporan (status -> ditolak + email konfirmasi)
- Epic: Laporan ODGJ Workflow
- User story: Sebagai admin, saya ingin menolak laporan jika tidak valid sehingga pelapor mengetahui keputusan.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Aksi `tolak` mengubah status laporan menjadi `ditolak`.
  2. Email konfirmasi dikirim jika email pelapor tersedia.
  3. Sistem tidak mengirim email duplikat pada aksi yang sama (jika implementasi mensyaratkan).

---
## PB-032 Admin: Kirim Respon Laporan ke Pelapor (pesan_respon)
- Epic: Laporan ODGJ Workflow
- User story: Sebagai admin, saya ingin mengirim respon tertulis agar pelapor mendapat tindak lanjut via email.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Field `pesan_respon` wajib dan max 2000 karakter.
  2. Respon hanya bisa dikirim jika `laporan.email` tersedia.
  3. Sistem mengembalikan pesan sukses/gagal kirim.

---

## PB-033 Donasi QRIS: Form Donasi Berbasis Program
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai donatur, saya ingin mengisi form donasi (program, identitas, jumlah) agar dapat melakukan pembayaran QRIS.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Form mendukung parameter program via query (contoh `/donasi?program=umum`).
  2. Validasi: nama, email, telepon, jumlah (min Rp 10.000), dan pesan opsional.
  3. Program label yang ditampilkan sesuai daftar program sistem.

---
## PB-034 Donasi QRIS: Simpan Transaksi “pending” & Generate `order_id`
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai sistem, saya ingin menyimpan donasi dengan status awal pending sehingga proses pembayaran dapat dilacak.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Donasi tersimpan dengan status `pending`.
  2. `order_id` unik dengan format prefiks `PJ-...`.
  3. Field `transaction_id`, `qr_code_url`, dan `qr_string` masih null sampai Core API mengembalikan.

---
## PB-035 Donasi QRIS: Permintaan Core API Midtrans dan Tampilkan QR
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai donatur, saya ingin melihat QR Code untuk menyelesaikan pembayaran.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Setelah submit form, pengguna diarahkan ke halaman `/donasi/{id}/bayar`.
  2. Halaman menampilkan QR (URL dari `response->actions[0]->url`).
  3. Jika Core API gagal, sistem tetap membuat catatan transaksi tanpa error fatal.
- Dependensi: `services.midtrans.server_key` dan sandbox/production.

---
## PB-036 Donasi QRIS: Halaman Pembayaran + Auto Check Status (AJAX polling)
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai donatur, saya ingin status donasi ter-update saat pembayaran selesai.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Endpoint check status mengembalikan JSON `{status: ...}`.
  2. Polling berhenti saat status menjadi final (`paid`/`failed`/expired).
  3. Redirect menuju halaman sukses setelah `paid`.

---
## PB-037 Donasi QRIS: Webhook/Callback Midtrans
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai gateway pembayaran, saya ingin mengirim notifikasi pembayaran agar status donasi sesuai.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Callback `POST /donasi/callback` memproses `order_id` dan `transaction_status`.
  2. Status settlement/capture mengubah donasi menjadi `paid` dan menyimpan `paid_at`.
  3. Status cancel/deny/expire mengubah donasi menjadi `failed`.
  4. Email thank-you dikirim hanya jika sebelumnya status belum `paid`.
  5. Response callback `OK` untuk proses sukses (atau error status sesuai kebutuhan).

---
## PB-038 Donasi: Kirim Email Terima Kasih Donatur
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai donatur, saya ingin menerima email ucapan terima kasih setelah pembayaran berhasil.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Email dikirim menggunakan template mailable yang memuat detail donasi.
  2. Kegagalan pengiriman email tidak merusak status pembayaran.
  3. Email tidak duplikat untuk transaksi yang sudah `paid`.

---
## PB-039 Donasi: Halaman Sukses Donasi
- Epic: Donasi QRIS & Pembayaran
- User story: Sebagai donatur, saya ingin melihat bukti transaksi setelah pembayaran berhasil.
- Prioritas: `Must (M)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Halaman success menampilkan detail donasi.
  2. Menampilkan bukti/QR jika tersedia.
  3. Visual tidak error walau data optional (mis. `qr_code_url` null).

---
## PB-040 Transparansi Donasi: Dashboard Publik (ringkasan & daftar)
- Epic: Transparansi Donasi
- User story: Sebagai pengunjung publik, saya ingin melihat ringkasan donasi dan pengeluaran.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Halaman menampilkan total donasi, jumlah paid/pending/failed, total terkumpul, pengeluaran, dan sisa.
  2. Daftar donasi dan pengeluaran memiliki paginasi.
  3. Query menghitung jumlah berdasarkan status (`paid`, `pending`, `expired`, `failed`).

---
## PB-041 Transparansi Donasi: Ekspor PDF Laporan Donasi
- Epic: Transparansi Donasi
- User story: Sebagai admin/pengunjung, saya ingin mengunduh PDF laporan donasi sebagai arsip.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Endpoint PDF mengunduh file untuk semua donasi terurut terbaru.
  2. Layout PDF (landscape) mengikuti template Blade khusus.
  3. Tidak error jika jumlah data besar (sesuai kapasitas server).
- Dependensi: `barryvdh/laravel-dompdf`.

---
## PB-042 Transparansi Donasi: Ekspor PDF Laporan Pengeluaran
- Epic: Transparansi Donasi
- User story: Sebagai admin/pengunjung, saya ingin mengunduh PDF laporan pengeluaran.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Endpoint PDF pengeluaran mengunduh file (portrait) dari template Blade khusus.
  2. Data berasal dari tabel `donation_expenses` terurut.
  3. Filename diberi timestamp tanggal (YYYY-MM-DD).

---

## PB-043 Admin CRUD Pasien (termasuk foto & status)
- Epic: Manajemen Data Operasional
- User story: Sebagai admin, saya ingin mengelola data pasien (aktif/selesai/dirujuk) agar proses rehabilitasi terdokumentasi.
- Prioritas: `Must (M)`
- Estimasi: 7 SP
- Acceptance criteria:
  1. Form pasien memvalidasi status dan memperlakukan `tanggal_keluar` hanya jika status `selesai`.
  2. Foto pasien disimpan di disk publik dan gambar lama dihapus saat diganti.
  3. Notifikasi email dikirim ke petugas saat pasien dibuat/diperbarui/dihapus.
  4. Admin dapat mencari/filter pasien dari halaman index.
- Dependensi: tabel `patients`, relasi notifikasi.

---
## PB-044 Public Patients: Halaman Publik Pasien
- Epic: Manajemen Data Operasional
- User story: Sebagai pengunjung, saya ingin melihat informasi pasien yang tersedia untuk halaman publik.
- Prioritas: `Should (S)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Endpoint publik `GET /pasien` mengarahkan ke profil pasien pertama (atau daftar bila diterapkan).
  2. Endpoint publik `/pasien/{patient}` menampilkan view yang tidak mengungkap data sensitif.
  3. Jika tidak ada pasien, redirect ke `welcome` dengan pesan.

---
## PB-045 Admin: Tambah/CRUD Aktivitas Pasien (termasuk hasil evaluasi + batch)
- Epic: Manajemen Data Operasional
- User story: Sebagai admin/petugas, saya ingin mencatat aktivitas pasien agar kegiatan rehabilitasi terdokumentasi.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Aktivitas mendukung jenis aktivitas (terapi, senam, keterampilan, ibadah, rekreasi, lainnya).
  2. Mendukung upload gambar (pada implementasi “store simple”) dan menyimpan `batch_uuid` untuk group.
  3. Field `hasil_evaluasi` tersimpan jika ada.
  4. Index menampilkan group berdasarkan `batch_uuid` atau single activity.

---
## PB-046 Admin: Simpan Aktivitas Pasien “Store Simple” (bulk untuk banyak pasien)
- Epic: Manajemen Data Operasional
- User story: Sebagai petugas, saya ingin mencatat aktivitas yang sama untuk banyak pasien sekaligus.
- Prioritas: `Should (S)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Form memilih `patient_ids[]` dan menyimpan aktivitas untuk tiap pasien.
  2. Image upload untuk aktivitas batch menghasilkan beberapa path.
  3. Sistem menampilkan pesan sukses dengan jumlah pasien.
- Dependensi: desain UI `patient-activities/store-simple`.

---
## PB-047 Admin: Duplikasi Aktivitas Pasien
- Epic: Manajemen Data Operasional
- User story: Sebagai admin, saya ingin menduplikasi aktivitas agar tidak menginput ulang data.
- Prioritas: `Could (C)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Action duplicate membuat record baru dengan `tanggal = now()`.
  2. Field lain disalin menggunakan `replicate()` dengan pengecualian `tanggal`.

---
## PB-048 Admin: CRUD Riwayat Pemeriksaan Pasien
- Epic: Manajemen Data Operasional
- User story: Sebagai admin, saya ingin mencatat riwayat pemeriksaan agar data klinis tersusun rapi.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Validasi field: tanggal, tempat pemeriksaan (wajib), keluhan/hasil/tindakan (opsional).
  2. Index mendukung pencarian berdasarkan nama pasien.
  3. Notifikasi email dikirim saat riwayat dibuat/diperbarui/dihapus.

---
## PB-049 Admin: CRUD Jadwal Pasien (multi-pasien per jadwal)
- Epic: Manajemen Data Operasional
- User story: Sebagai admin, saya ingin membuat jadwal kunjungan pasien dan mengelola statusnya.
- Prioritas: `Must (M)`
- Estimasi: 7 SP
- Acceptance criteria:
  1. Form memungkinkan input `patient_ids[]` untuk membuat jadwal sekaligus.
  2. Validasi reminder sebelum menit hanya menerima list nilai yang diperbolehkan.
  3. Field `jenis`, `status`, `tempat`, dan `catatan` tersimpan sesuai aturan.
  4. Notifikasi email ke petugas terjadi saat create/update/destroy.

---
## PB-050 Pengingat Jadwal Pasien ke Pembimbing (Scheduler)
- Epic: Manajemen Data Operasional
- User story: Sebagai sistem, saya ingin mengirim email pengingat jadwal pasien ke pembimbing sesuai waktu.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Artisan scheduler menjalankan command `patient-schedule:send-reminders` setiap menit.
  2. Email pengingat 1 dikirim jika `reminder_sent_at` null dan waktu >= `tanggal+jam_mulai - reminder_before_minutes`.
  3. Email pengingat 2 dikirim tepat saat waktu mulai jika `start_reminder_sent_at` null.
  4. Setelah mengirim, sistem menyimpan timestamp dan tidak mengirim ulang.
- Dependensi: konfigurasi SMTP, job mailable `PatientScheduleReminderToPembimbing`.

---

## PB-051 Admin: Jadwal Rehabilitasi (CRUD) + Notifikasi Petugas
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mengatur jadwal rehabilitasi harian/mingguan agar petugas siap menjalankan kegiatan.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Validasi `hari` hanya salah satu dari daftar (senin..minggu).
  2. `jam_selesai` harus lebih besar dari `jam_mulai` jika diisi.
  3. Notifikasi email dikirim ke petugas saat schedule dibuat/diperbarui/dihapus.
  4. Field `pembimbing_id` tersimpan dan dipakai pada relasi.

---
## PB-052 Ekspor PDF Jadwal Rehabilitasi
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mengunduh PDF jadwal rehabilitasi sebagai dokumentasi kegiatan.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Export PDF mendukung filter `hari` bila diberikan.
  2. Menggunakan template Blade ekspor dan paper landscape A4.
  3. Filename memiliki tanggal pembuatan.
- Dependensi: DomPDF.

---
## PB-053 Jadwal Petugas: Shift Master Data (CRUD)
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mengelola daftar shift agar penjadwalan petugas fleksibel.
- Deskripsi: Gunakan entity `shifts` berisi nama dan jam mulai/selesai.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Admin dapat menambah/mengubah/menghapus shift.
  2. Shift default (Pagi/Siang/Malam) tersedia jika kebijakan.
  3. Jam shift tersimpan dan dipakai pada jadwal.

---
## PB-054 Jadwal Petugas: Kalender + Filter (hari/shift/user/periode)
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin melihat jadwal petugas dalam tampilan tabel dan kalender serta memfilter.
- Prioritas: `Must (M)`
- Estimasi: 7 SP
- Acceptance criteria:
  1. Index menampilkan statistik bulan ini dan hari ini.
  2. Filter mendukung `period`, `user_id`, `tanggal_dari`, `tanggal_sampai`, `shift_id` atau `shift`.
  3. Jadwal yang bertepatan dengan libur khusus (`jadwal_libur`) tersembunyi.

---
## PB-055 Jadwal Petugas: Bulk Create Jadwal Berulang (mingguan/2mingguan/bulanan)
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin membuat jadwal petugas berulang berdasarkan pola supaya tidak input manual harian.
- Prioritas: `Must (M)`
- Estimasi: 8 SP
- Acceptance criteria:
  1. Input tanggal dari/sampai, ulang set (minggu/2minggu/bulan).
  2. Memilih hari dan shift per hari; sistem membuat record sesuai pola.
  3. Bentrok jadwal pada user yang sama tidak dibuat (skipped) dan sistem menginformasikan jumlah created/skipped.
  4. Jam mulai/jam selesai ikut shift.
- Dependensi: fungsi getDatesForRepeatPattern.

---
## PB-056 Jadwal Petugas: Libur Khusus per Tanggal
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin menandai petugas libur pada tanggal tertentu sehingga tidak muncul di jadwal.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. `jadwal_libur` menyimpan `user_id` dan `tanggal` unik.
  2. Index jadwal petugas mengecualikan libur khusus via query.
  3. Validasi input memastikan user dan tanggal valid.

---
## PB-057 Jadwal Petugas: Jadwal Pengganti (Ganti shift pada tanggal tertentu)
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mencatat jadwal pengganti untuk meng-cover jadwal libur rutinitas.
- Prioritas: `Should (S)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Action ganti shift menyimpan record dengan tipe `ganti` pada tanggal tertentu.
  2. Jadwal pengganti mengadopsi jam dari shift yang dipilih.
  3. Notifikasi email dikirim saat pengaturan jadwal diperbarui/dihapus.

---
## PB-058 Ekspor PDF Jadwal Petugas
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mengunduh PDF jadwal petugas.
- Prioritas: `Should (S)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Export PDF menampilkan kalender jadwal per bulan dan berisi data yang sesuai filter.
  2. Filename memiliki format `jadwal-petugas-YYYY-MM.pdf`.
  3. Template Blade ekspor konsisten.

---

## PB-059 Admin: Jadwal Petugas CRUD Individual
- Epic: Penjadwalan Rehabilitasi & Petugas
- User story: Sebagai admin, saya ingin mengubah dan menghapus jadwal petugas tunggal.
- Prioritas: `Must (M)`
- Estimasi: 4 SP
- Acceptance criteria:
  1. Update tidak mengizinkan bentrok shift yang sama pada user/tanggal.
  2. Update/destroy mengirim notifikasi email ke petugas terkait.
  3. Data edit menampilkan shift yang dipilih konsisten.

---
## PB-060 Stok: Manajemen Persediaan (Stock Supply) CRUD + Gambar
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mengelola persediaan stok barang (nama, jumlah, harga, gambar).
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Supply dapat ditambah/diubah/dihapus beserta gambar opsional.
  2. Jika gambar diganti, file lama terhapus dari storage.
  3. Index stok menampilkan sisa per nama = total supply - total expenses.

---
## PB-061 Stok: Manajemen Pengeluaran (DonationExpense / StockExpense)
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mencatat pengeluaran stok untuk kebutuhan operasional.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Pengeluaran memilih `nama` dari daftar supply yang ada.
  2. Validasi jumlah > 0 dan tanggal pengeluaran wajib.
  3. Gambar bukti opsional; jika ada diganti, file lama dihapus.

---
## PB-062 Stok Inventori (Inventory Items): Tambah Item Baru + Restock
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mencatat stok menggunakan sistem inventori (unit, min stock, expiry, supplier) dan restock.
- Prioritas: `Must (M)`
- Estimasi: 7 SP
- Acceptance criteria:
  1. Item baru menyimpan `category`, `unit`, `min_stock`, `expiry_date`, `supplier` (opsional), dll.
  2. Mode restock meningkatkan `quantity` dan menulis transaksi `StockTransaction` type `in`.
  3. Transaksi selalu mencatat `staff_name` dan `user_id` bila tersedia.
- Dependensi: tabel `inventory_items` dan `stock_transactions`.

---
## PB-063 Stok Inventori: Pemakaian Barang (Stock Out) + Validasi Stok Tidak Minus
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mencatat pemakaian stok tanpa membuat stok menjadi negatif.
- Prioritas: `Must (M)`
- Estimasi: 6 SP
- Acceptance criteria:
  1. Stock out memvalidasi `item_id` dan `quantity`.
  2. Jika stok tidak cukup, sistem menolak dengan pesan error.
  3. Jika sukses, stok berkurang dan membuat transaction type `out`.

---
## PB-064 Notifikasi Stok: Habis / Hampir Habis ke Email Petugas
- Epic: Stok & Inventori
- User story: Sebagai petugas, saya ingin menerima notifikasi saat stok habis atau mendekati batas minimum.
- Prioritas: `Should (S)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Sistem memeriksa kondisi setelah stock out: jika `quantity <= 0` maka status `habis`, jika `quantity <= min_stock` maka status `hampir_habis`.
  2. Email dikirim ke daftar user role admin/manager/petugas yang email-nya valid.
  3. Jika email tidak tersedia untuk user tertentu, sistem tidak error.

---
## PB-065 Ekspor CSV Stok Barang
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mengekspor data stok ke format CSV untuk laporan.
- Prioritas: `Should (S)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Export CSV mengunduh file dengan delimiter `;`.
  2. Kolom yang diekspor mencakup nama, kategori, jumlah, unit, min stock, tanggal masuk, kadaluarsa, supplier, harga/unit, status.
  3. Export menggunakan streaming respons (tidak membebani RAM berlebih).
- Dependensi: response type `StreamedResponse`.

---

## PB-066 Ekspor PDF/Petugas (opsional jika dibutuhkan dalam ruang lingkup)
- Epic: Stok & Inventori
- User story: Sebagai admin, saya ingin mengekspor daftar petugas/jadwal ke PDF/Excel untuk arsip.
- Prioritas: `Could (C)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Endpoint ekspor tersedia sesuai kebutuhan (Excel untuk petugas, PDF untuk petugas/jadwal).
  2. Format PDF/Excel sesuai template/headers.

---
## PB-067 Backlog Non-fungsional: Performance pada Index Dashboard (pagination + eager loading)
- Epic: Hardening & Testing
- User story: Sebagai pengguna admin, saya ingin halaman index tetap cepat saat data bertambah.
- Prioritas: `Should (S)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Query index menggunakan pagination untuk dataset besar.
  2. Relasi penting di-load dengan `with()` agar mengurangi N+1.
  3. Endpoint tidak timeout pada skenario data dummy menengah.

---
## PB-068 Backlog Non-fungsional: Audit Log CRUD (opsional untuk skripsi)
- Epic: Hardening & Testing
- User story: Sebagai admin, saya ingin jejak audit agar perubahan data dapat ditelusuri.
- Prioritas: `Could (C)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Setiap aksi create/update/delete tercatat minimal: entitas, user_id, waktu, dan tipe aksi.
  2. Log tidak menulis data sensitif (foto/file path bisa opsional).
  3. Halaman audit log tersedia untuk admin.

---
## PB-069 Pengujian Black-Box per Modul (donasi, laporan ODGJ, pasien, jadwal, stok)
- Epic: Hardening & Testing
- User story: Sebagai peneliti/QA, saya ingin daftar skenario uji agar sistem terverifikasi.
- Prioritas: `Must (M)`
- Estimasi: 5 SP
- Acceptance criteria:
  1. Donasi: validasi, pembayaran sukses/gagal, callback status, email thank-you.
  2. Laporan ODGJ: upload validasi, status awal, email notifikasi, aksi terima/tolak/respon.
  3. Operasional: CRUD pasien/aktivitas/riwayat pemeriksaan/jadwal, validasi edge-case.
  4. Stok: tambah supply, catat expense, stock out, notifikasi stok.

---
## PB-070 Pengujian Integrasi Midtrans (Sandbox/Production plan)
- Epic: Hardening & Testing
- User story: Sebagai engineer, saya ingin rencana verifikasi integrasi Midtrans jelas.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. Sistem bisa menghasilkan QR code di sandbox.
  2. Callback sandbox mengubah status donasi menjadi paid/failed sesuai test-case.
  3. Tidak ada double email (hanya sekali untuk paid).

---
## PB-071 Pengujian PDF Rendering (DomPDF)
- Epic: Hardening & Testing
- User story: Sebagai admin, saya ingin PDF tampak benar untuk arsip.
- Prioritas: `Must (M)`
- Estimasi: 3 SP
- Acceptance criteria:
  1. PDF donasi landscape, PDF pengeluaran portrait sesuai spesifikasi.
  2. PDF jadwal rehabilitasi dan jadwal petugas berhasil diunduh dan formatnya konsisten.
  3. Tabel tidak terpotong (minimal uji data dummy).

---
## PB-072 UX: Feedback Flash Messages untuk Semua Aksi CRUD
- Epic: Hardening & Testing
- User story: Sebagai pengguna admin, saya ingin mengetahui hasil aksi (sukses/gagal) dengan jelas.
- Prioritas: `Should (S)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Create/update/delete menampilkan flash message.
  2. Error validasi menampilkan pesan sesuai field.
  3. Halaman tidak blank setelah aksi.

---
## PB-073 Dokumentasi Operasional untuk Admin (setup konfigurasi Midtrans/SMTP)
- Epic: Hardening & Testing
- User story: Sebagai admin/peneliti, saya ingin panduan konfigurasi agar sistem bisa dijalankan.
- Prioritas: `Should (S)`
- Estimasi: 2 SP
- Acceptance criteria:
  1. Dokumentasi mencakup `MIDTRANS_*` dan pengaturan `MAIL_*`.
  2. Mencakup endpoint callback yang benar.
  3. Mencakup cara menjalankan migration dan memastikan storage terizin.

---

## Penutup
Dokumen ini adalah template Product Backlog yang bisa disesuaikan berdasarkan data wawancara yayasan (Product Owner). Jika diperlukan, backlog dapat dipetakan menjadi `sprint backlog` per sprint dengan memilih item berdasarkan prioritas `Must` terlebih dahulu.

