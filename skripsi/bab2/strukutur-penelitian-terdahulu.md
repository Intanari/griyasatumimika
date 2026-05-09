# Struktur Penelitian Terdahulu Berdasarkan Struktur Aplikasi

Dokumen ini menjelaskan struktur aplikasi **Griya Satu Mimika** sebagai dasar menyusun bagian **penelitian terdahulu** pada Bab II. Fokusnya adalah memetakan fitur sistem ke tema penelitian agar pembahasan studi terdahulu lebih sistematis dan relevan dengan implementasi aplikasi.

---

## 1. Gambaran Singkat Aplikasi

Aplikasi ini dibangun dengan **Laravel (arsitektur MVC)** dan memisahkan akses menjadi dua domain:

- **Domain publik**: menampilkan informasi yayasan, layanan, galeri, donasi, laporan ODGJ, dan transparansi.
- **Domain admin**: digunakan petugas/admin untuk login, mengelola data operasional, serta memantau laporan dan donasi.

Pemisahan ini cocok dijadikan landasan dalam penelitian terdahulu terkait sistem informasi web, transparansi layanan sosial, dan tata kelola data berbasis peran.

---

## 2. Struktur Teknis yang Relevan untuk Penelitian Terdahulu

### a. Lapisan Presentasi (View)

- Lokasi: `resources/views/`
- Fungsi: menyajikan antarmuka publik dan dashboard admin.
- Nilai penelitian: dapat dibandingkan dengan studi terdahulu tentang usability, desain antarmuka, dan aksesibilitas informasi organisasi sosial.

### b. Lapisan Logika Aplikasi (Controller)

- Lokasi: `app/Http/Controllers/`
- Fungsi: menangani alur proses bisnis seperti donasi, laporan ODGJ, pengelolaan pasien, jadwal, stok, dan konten profil.
- Nilai penelitian: menjadi dasar analisis penelitian terdahulu tentang otomatisasi proses layanan, alur verifikasi, dan manajemen data.

### c. Lapisan Data (Model + Database)

- Lokasi model: `app/Models/`
- Lokasi migrasi: `database/migrations/`
- Fungsi: menyimpan entitas utama (pasien, donasi, laporan, stok, jadwal, profil yayasan) dalam basis data relasional.
- Nilai penelitian: mendukung pembahasan studi terdahulu tentang perancangan basis data, konsistensi data, dan efisiensi pelaporan.

### d. Lapisan Rute dan Keamanan Akses

- Lokasi: `routes/web.php`
- Fungsi: pemetaan URL ke controller, pemisahan domain publik/admin, middleware `auth` dan `guest`.
- Nilai penelitian: relevan untuk membandingkan pendekatan kontrol akses, autentikasi, dan pemisahan hak akses pada penelitian sejenis.

---

## 3. Struktur Modul Aplikasi untuk Klasifikasi Penelitian Terdahulu

Berikut struktur modul yang dapat dijadikan kategori saat meninjau penelitian terdahulu:

1. **Modul Informasi Publik Yayasan**  
   Fokus kajian: website profil lembaga, publikasi layanan, dan komunikasi publik.

2. **Modul Donasi Digital**  
   Fokus kajian: payment gateway, notifikasi transaksi, dan transparansi dana.

3. **Modul Laporan ODGJ dari Masyarakat**  
   Fokus kajian: pelaporan online, validasi/admin approval, dan tindak lanjut layanan.

4. **Modul Manajemen Pasien dan Rehabilitasi**  
   Fokus kajian: pencatatan data pasien, jadwal rehabilitasi, dan riwayat pemeriksaan.

5. **Modul Manajemen Petugas, Jadwal, dan Stok**  
   Fokus kajian: efisiensi operasional internal, penjadwalan SDM, dan kontrol persediaan.

6. **Modul Konten Dinamis dan Pengaturan Web**  
   Fokus kajian: content management untuk organisasi sosial dan kemudahan pemeliharaan sistem.

---

## 4. Cara Menyusun Subbab Penelitian Terdahulu

Gunakan struktur berikut agar penelitian terdahulu selaras dengan kebutuhan sistem:

1. Kelompokkan jurnal/skripsi berdasarkan **modul** (donasi, pelaporan, pasien, stok, dll).
2. Jelaskan **metode/teknologi** yang digunakan tiap penelitian (framework, model data, integrasi pembayaran, dsb).
3. Bandingkan **kelebihan dan kekurangan** penelitian terdahulu terhadap kebutuhan aplikasi ini.
4. Tunjukkan **celah penelitian (research gap)** yang belum terpenuhi, lalu kaitkan dengan fitur yang dibangun pada sistem ini.

---

## 5. Template Ringkas Tabel Penelitian Terdahulu

Template berikut bisa dipakai di naskah Bab II:

| No | Peneliti & Tahun | Topik/Objek | Metode/Teknologi | Hasil Utama | Keterkaitan dengan Aplikasi Ini |
|----|------------------|-------------|------------------|-------------|----------------------------------|
| 1  | ...              | ...         | ...              | ...         | Relevan pada modul ...           |
| 2  | ...              | ...         | ...              | ...         | Menjadi pembanding untuk ...     |

---

## 6. Kesimpulan

Struktur aplikasi ini dapat dijadikan kerangka langsung untuk menyusun penelitian terdahulu secara tematik. Dengan memetakan studi sebelumnya ke modul-modul utama sistem, pembahasan Bab II menjadi lebih terarah, mudah dibandingkan, dan kuat dalam menunjukkan posisi kontribusi penelitian yang sedang dilakukan.
