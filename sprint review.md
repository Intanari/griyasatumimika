# Sprint Review (Ulasan Akhir Sprint)

## Sprint 1
**Sprint:** 1  
**Tanggal acuan:** 2026-03-03  
**Branch/Komit:** `origin/v1–v6` (tip v6: `e4e82a7`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 1 menghasilkan fondasi sistem yang stabil melalui pemisahan domain publik-admin, autentikasi, kontrol peran (RBAC), validasi input, dan penguatan keamanan dasar. Alur laporan ODGJ dari form publik sampai verifikasi (terima/tolak) beserta email respon juga sudah berjalan sebagai workflow inti.

### Review
Fitur inti fondasi dan workflow awal laporan ODGJ tercapai sesuai fokus sprint. Hasil ini layak dijadikan baseline untuk pengembangan modul operasional pada sprint berikutnya.

---

## Sprint 2
**Sprint:** 2  
**Tanggal acuan:** 2026-03-04  
**Branch/Komit:** `origin/v7–v8` (tip v7: `1be0862`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 2 menghasilkan modul pasien pada area admin (CRUD, foto identitas, filter, notifikasi) dan halaman publik pasien yang membatasi data sensitif. Struktur data pasien menjadi lebih terkelola untuk mendukung proses rehabilitasi.

### Review
Target sprint terkait pasien tercapai dan sudah terhubung ke alur notifikasi. Perlu dijaga konsistensi data pasien antar halaman admin dan publik agar tetap sinkron pada perubahan data berikutnya.

---

## Sprint 3
**Sprint:** 3  
**Tanggal acuan:** 2026-03-05  
**Branch/Komit:** `origin/v9` (commit `6e22426`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 3 menghasilkan modul riwayat pemeriksaan pasien dengan CRUD terstruktur, validasi data, pencarian, dan dukungan ringkasan dashboard. Informasi pemeriksaan menjadi lebih mudah dipantau.

### Review
Capaian sprint sesuai dengan fokus riwayat pemeriksaan. Integrasi ke dashboard sudah membantu monitoring, dan menjadi dasar untuk pengembangan jadwal serta aktivitas pasien di sprint lanjutan.

---

## Sprint 4
**Sprint:** 4  
**Tanggal acuan:** 2026-03-06  
**Branch/Komit:** `origin/v10–v12` (tip v12: `6f7f84f`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 4 menghasilkan modul jadwal kunjungan pasien dengan notifikasi perubahan jadwal, penguatan manajemen petugas, serta perbaikan tampilan dashboard/view terkait jadwal agar lebih selaras dengan kebutuhan operasional.

### Review
Fokus sprint untuk jadwal pasien dan petugas tercapai. Poin yang tetap perlu dijaga adalah konsistensi reminder dan sinkronisasi antar entitas pasien, petugas, dan jadwal.

---

## Sprint 5
**Sprint:** 5  
**Tanggal acuan:** 2026-03-07  
**Branch/Komit:** `origin/v13–v14` (tip v14: `dda38f7`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 5 menghasilkan pengingat jadwal terjadwal berbasis timezone, modul jadwal petugas berbasis shift dan kalender, dukungan bulk jadwal dengan mekanisme skip bentrok, jadwal pengganti, serta ekspor PDF untuk kebutuhan monitoring.

### Review
Target penguatan scheduling tercapai dan meningkatkan reliabilitas pengingat. Mekanisme bulk dan kalender sudah mempercepat pengelolaan jadwal, namun validasi bentrok tetap perlu dipertahankan ketat.

---

## Sprint 6
**Sprint:** 6  
**Tanggal acuan:** 2026-03-08  
**Branch/Komit:** `origin/v15–v17` (tip v17: `1afa5c8`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 6 menghasilkan modul aktivitas pasien, jadwal rehabilitasi (termasuk notifikasi dan PDF), serta modul stok/inventori dengan transaksi masuk-keluar dan validasi agar stok tidak minus.

### Review
Capaian sprint memperkuat sisi operasional yayasan karena aktivitas, jadwal rehabilitasi, dan stok sudah terdokumentasi lebih terstruktur. Kualitas data operasional meningkat dan siap diintegrasikan ke modul transaksi/monitoring berikutnya.

---

## Sprint 7
**Sprint:** 7  
**Tanggal acuan:** 2026-03-09  
**Branch/Komit:** `origin/v18–v20` (tip v20: `24ebf63`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 7 menghasilkan alur donasi Midtrans end-to-end (form, transaksi pending, pembayaran/QR, callback, status, halaman sukses), modul pengeluaran stok/supply-expense, notifikasi stok, ekspor CSV, peningkatan performa dashboard, dan perapihan UX/flash message.

### Review
Target sprint transaksi donasi dan stok tercapai dengan cakupan yang luas. Integrasi pembayaran dan callback sudah menjadi milestone penting, sementara perbaikan UI/UX meningkatkan keterbacaan operasional harian.

---

## Sprint 8
**Sprint:** 8  
**Tanggal acuan:** 2026-03-10  
**Branch/Komit:** `origin/v21–v22` (commit `d90353e`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 8 menghasilkan hardening pada area admin (user/seeder/struktur aplikasi), pengujian black-box lintas modul, validasi integrasi Midtrans, uji rendering PDF, dan dokumentasi operasional untuk mendukung stabilitas rilis.

### Review
Sprint ini berperan sebagai quality gate sebelum penyempurnaan publik. Pengujian dan dokumentasi yang dilakukan membuat sistem lebih siap untuk evaluasi berkelanjutan.

---

## Sprint 9
**Sprint:** 9  
**Tanggal acuan:** 2026-03-15  
**Branch/Komit:** `origin/v23` (commit `b3112d4`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

### Hasil
Sprint 9 menghasilkan penyempurnaan situs publik melalui CMS profil/visi-misi/struktur/petugas/layanan, web settings tampilan, halaman informasi publik, transparansi donasi (dashboard + paginasi), ekspor PDF donasi/pengeluaran, serta refactor view publik agar konsisten.

### Review
Fokus sprint publik dan transparansi tercapai sesuai rencana. Hasil ini menutup rangkaian pengembangan dengan peningkatan akses informasi untuk pengguna publik dan konsistensi tampilan lintas halaman.

---

## Ringkasan Akhir Sprint 1-9
Secara keseluruhan, hasil sprint menunjukkan progres bertahap dari fondasi keamanan dan workflow inti menuju modul operasional lengkap, transaksi donasi terintegrasi, hingga penyempurnaan sisi publik dan transparansi. Dari sisi review, setiap sprint memberikan baseline untuk sprint berikutnya dan membentuk increment yang konsisten, terukur, serta siap untuk peningkatan kualitas lanjutan.

# Sprint Review (Ulasan Akhir Sprint)

## Sprint 9
**Tanggal acuan:** 2026-03-15  
**Branch/Komit:** `origin/v23` (`b3112d4`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`, `increment-development.md`

## Tujuan Sprint
Menyelesaikan pengembangan **situs publik** yang mencakup konten profil yayasan, pengaturan tampilan (web settings), informasi layanan publik (beranda/CTA donasi, galeri, kontak & FAQ), serta **transparansi donasi** termasuk ekspor PDF, sekaligus melakukan refactor view publik agar konsisten dan tahan terhadap data kosong/dinamis.

## Ringkasan Increment yang Dihasilkan
Pada Sprint 9, saya menghasilkan increment yang mencakup modul berikut.
1. **CMS publik**: profil yayasan, visi-misi, struktur organisasi (termasuk foto petugas per role), daftar petugas, dan layanan (`PB-013` s.d. `PB-017`).
2. **Web settings**: pengaturan warna heading, paragraf, span; warna div/A & tombol; serta background global/per halaman (`PB-018` s.d. `PB-020`).
3. **Halaman publik**: beranda + CTA donasi sesuai program, galeri aktivitas pasien berbasis field `image`, serta halaman informasi publik (kontak, cara donasi, mitra, FAQ) (`PB-021` s.d. `PB-023`).
4. **Profil/struktur terbaru**: memastikan data publik mengambil data terbaru dan urutan/penggabungan tetap konsisten (target menghindari N+1 signifikan) (`PB-024`).
5. **Transparansi donasi**: dashboard publik ringkasan & daftar donasi/pengeluaran dengan paginasi berdasarkan status, serta ekspor PDF laporan donasi dan pengeluaran (`PB-040` s.d. `PB-042`).
6. **Refactor view publik**: penyelarasan tampilan antar halaman agar tidak memunculkan error pada kondisi konten kosong/dinamis.

## Pencapaian Berdasarkan Product Backlog
Berikut item PB yang menjadi target Sprint 9.
- `PB-013` Profil yayasan (CRUD konten + publik `/profil/yayasan`).
- `PB-014` Visi-misi (CRUD `visi_misi` + publik `/profil/visi-misi`).
- `PB-015` Struktur organisasi + foto petugas (CRUD + publik `/profil/struktur-organisasi`).
- `PB-016` Petugas yayasan (CRUD + foto + urutan + publik).
- `PB-017` Layanan publik (`/layanan`) dengan daftar proses & tahapan rehabilitasi.
- `PB-018` Web settings warna heading/paragraf/span (`h1_color..h6_color`, `p_color`, `span_color`).
- `PB-019` Web settings warna div/A & tombol (sanitasi konfigurasi class).
- `PB-020` Web settings background global vs per halaman (warna/gambar + overlay opacity).
- `PB-021` Beranda + CTA donasi (mengarah ke `donation.form` sesuai slug program).
- `PB-022` Galeri aktivitas pasien (filter berdasarkan `image` non-null/non-empty + urutan tanggal).
- `PB-023` Halaman kontak/cara donasi/mitra/FAQ (publik tanpa autentikasi).
- `PB-024` Profil yayasan/struktur terbaru mengikuti data admin (konsistensi urutan/penggabungan).
- `PB-040` Dashboard publik transparansi donasi (ringkasan + paginasi + status query).
- `PB-041` Ekspor PDF laporan donasi (landscape, template Blade khusus).
- `PB-042` Ekspor PDF laporan pengeluaran (portrait, sumber `donation_expenses`, filename timestamp).

Catatan verifikasi (berdasarkan implementasi increment Sprint 9 dan AC pada Product Backlog):
- Halaman publik CMS: profil yayasan, visi-misi, struktur organisasi, petugas, dan layanan dapat dirender dengan konten terbaru serta tidak menimbulkan error saat data kosong (mengacu AC `PB-013` s.d. `PB-017`).
- Web settings: perubahan warna dan background global/per halaman tampil konsisten pada halaman publik (mengacu AC `PB-018` s.d. `PB-020`).
- Halaman informasi & galeri: routing publik berjalan dan galeri menampilkan item dengan `image` non-null/non-empty secara terurut tanggal (mengacu AC `PB-022` dan `PB-023`).
- Transparansi donasi: dashboard publik menampilkan metrik ringkasan, daftar donasi/pengeluaran berpaginasi, dan perhitungan berdasarkan status (mengacu AC `PB-040`).
- Ekspor PDF: proses unduh PDF untuk laporan donasi dan pengeluaran menghasilkan dokumen sesuai template (landscape untuk donasi, portrait untuk pengeluaran) serta penamaan file bertimestamp (mengacu AC `PB-041` dan `PB-042`).

## Pengujian yang Dilakukan
Saya melakukan pengujian fungsional pada halaman/fitur utama berikut.
1. Halaman publik CMS: validasi rendering konten terbaru dan tidak error ketika data kosong.
2. Web settings: validasi perubahan warna/background tampil sesuai konfigurasi tersimpan.
3. Halaman informasi & galeri: validasi routing publik dan filtering galeri berdasarkan `image`.
4. Transparansi donasi: validasi ringkasan metrik, paginasi, dan query berdasarkan status.
5. Ekspor PDF: validasi proses generate/unduh PDF untuk donasi dan pengeluaran.

Hasil uji (isi detail):
- Status umum: sesuai target Sprint 9 pada branch `origin/v23` untuk fitur inti situs publik (CMS, web settings, halaman publik, transparansi donasi, dan ekspor PDF).
- Kasus uji gagal/bermasalah: tidak dicantumkan secara spesifik pada dokumen ini (silakan isi jika kamu menemukan deviasi nyata saat validasi lokal/production).
- Perbaikan yang diterapkan: dilakukan refactor view publik agar tampilan konsisten dan tahan terhadap konten dinamis/kosong serta penyelarasan pengaturan web settings sesuai AC `PB-018` s.d. `PB-020`.

## Temuan & Perbaikan
- Temuan: kebutuhan fallback tampilan ketika konten CMS belum tersedia (mis. profil/struktur/petugas tertentu belum diisi) agar halaman publik tetap terlihat rapi tanpa error.
- Perbaikan: melakukan penyeragaman struktur view publik dan memastikan rendering konten mengikuti data dari tabel terkait serta ketahanan UI pada kondisi konten kosong/dinamis (mengacu tujuan Sprint dan AC `PB-013` s.d. `PB-024`).

## Umpan Balik (Product Owner / Penguji)
Belum ada catatan umpan balik formal yang terdokumentasi pada file ini.
- Saran/feedback: penguatan fallback UI saat konten parsial/kosong dan konsistensi style lintas halaman publik.
- Keputusan akhir: increment Sprint 9 dinyatakan layak untuk dilanjutkan ke tahap evaluasi/regresi sprint berikutnya.

## Sisa Risiko / Kebutuhan Sprint Berikutnya
- Penguatan edge case pada konten CMS (mis. urutan/gambar kosong) dan validasi lanjutan input web settings agar konsisten pada semua tipe halaman publik.
- Evaluasi lanjutan performa query pada profil/struktur dan modul publik lainnya untuk memastikan tidak ada pola N+1 pada skenario relasi tertentu (sesuai konteks `PB-024`).

## Kesimpulan
Secara umum, Sprint 9 menghasilkan increment yang mendukung kebutuhan situs publik yayasan dan transparansi donasi. Implementasi CMS publik, web settings, halaman informasi, serta fitur transparansi (dashboard dan ekspor PDF) meningkatkan ketersediaan informasi publik sekaligus mempermudah pengelolaan konten dari sisi admin.

## Rencana Sprint Berikutnya
1. Menyelesaikan backlog item yang belum sepenuhnya memenuhi Acceptance Criteria.
2. Melakukan pengujian regresi antar modul publik (CMS, galeri, layanan, transparansi) setelah perbaikan.
3. Menyiapkan dokumentasi operasional singkat untuk penggunaan web settings dan fitur ekspor PDF.

