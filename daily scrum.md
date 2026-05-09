## Daily Scrum Individu — 2026-03-15

**Sprint:** 9  
**Branch:** `origin/v23` (commit `b3112d4`)  
**Fokus sprint:** Situs publik: konten yayasan & transparansi donasi.

### Target Saya Hari Ini (berdasarkan `sprint backlog.md`)
- Halaman publik CMS yayasan selesai (profil, visi-misi, struktur organisasi, petugas, layanan).
- Web settings (warna & background) diterapkan konsisten ke halaman publik.
- Transparansi donasi (dashboard + ekspor PDF) tersedia untuk publik/admin.
- Refactor view publik agar konsisten dan tidak error pada data kosong.

### Checklist Target Saya (dirunut dari `product backlog.md`)
- [x] `PB-013` Profil yayasan: admin CRUD konten; publik `/profil/yayasan` menampilkan konten terbaru; validasi judul/keterangan.
- [x] `PB-014` Visi-misi: admin CRUD `visi_misi`; publik `/profil/visi-misi` terurut; tidak merusak layout jika kosong.
- [x] `PB-015` Struktur organisasi + foto: admin CRUD struktur & foto per role; urutan ikut `ROLES`/sorting; publik `/profil/struktur-organisasi`.
- [x] `PB-016` Petugas yayasan: admin CRUD petugas; foto tersimpan & tampil; urutan konsisten berdasarkan `urutan`.
- [x] `PB-017` Layanan (`/layanan`): admin CRUD `proses_laporan_odgj` & `tahapan_rehabilitasi`; publik menampilkan kedua daftar terurut.
- [x] `PB-018` Web settings heading: simpan `h1_color..h6_color`, `p_color`, `span_color`; perubahan tercermin di publik; input disanitasi & dibatasi.
- [x] `PB-019` Web settings div/A & tombol: simpan konfigurasi warna per class; publik menampilkan sesuai konfigurasi; sanitasi class name mencegah injection.
- [x] `PB-020` Web settings background: dukung `warna` dan `gambar`; global vs per halaman; overlay opacity diterapkan konsisten.
- [x] `PB-021` Beranda + CTA donasi: tombol donasi mengarah ke `donation.form` sesuai slug program; halaman tetap tampil walau data program dinamis.
- [x] `PB-022` Galeri aktivitas pasien: galeri hanya menampilkan aktivitas dengan `image` non-null/non-empty; terurut tanggal; klik item menampilkan detail (jika tersedia).
- [x] `PB-023` Kontak/cara donasi/mitra/FAQ: akses publik tanpa autentikasi; routing benar; tidak error saat data kosong.
- [x] `PB-024` Profil yayasan/struktur terbaru: publik membaca data dari tabel terkait; urutan/penggabungan konsisten (mis. struktur organisasi); hindari N+1 signifikan.
- [x] `PB-040` Transparansi donasi dashboard publik: total donasi & pengeluaran lengkap; paginasi; query berdasarkan status (`paid/pending/expired/failed`).
- [x] `PB-041` Ekspor PDF laporan donasi: endpoint PDF mengunduh file terurut terbaru; layout template landscape Blade khusus; aman untuk data besar.
- [x] `PB-042` Ekspor PDF laporan pengeluaran: endpoint PDF portrait; data dari `donation_expenses` terurut; filename timestamp `YYYY-MM-DD`.
- [x] Refactor view publik konsisten: pastikan tampilan antar halaman selaras dan tidak ada error saat konten belum tersedia.

### Progress Saya
- Yang sudah saya kerjakan: seluruh target Sprint 9 pada checklist selesai dan sesuai fokus sprint.
- Yang masih saya kerjakan: finalisasi dokumentasi hasil sprint (daily scrum, increment/development, dan sprint review).
- Hambatan/risiko saya: tidak ada hambatan kritis; tindak lanjut difokuskan pada penguatan edge case konten dinamis.

