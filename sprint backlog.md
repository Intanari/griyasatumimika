# Sprint Backlog — Penyusunan Tugas

**Produk:** Sistem Informasi Yayasan Griya Satu Mimika.  
**Sumber:** `product backlog.md` (PB-xxx), `sprint planning day.md` (sprint per tanggal kalender & branch `origin/v*`).  
**Durasi acuan Scrum:** ~2 minggu per sprint pada Product Backlog; dokumen ini menyelaraskan **sprint harian** (kelompok commit per tanggal) dengan **tugas** yang dapat di-assign.

**Cara membaca:** Setiap baris di bawah **Sprint Backlog** adalah tugas kerja (bisa jadi satu PR atau satu hari kerja). Kolom **PB** mengacu ke item di Product Backlog. **SP** mengikuti estimasi pada PB (jika satu tugas memetakan beberapa PB, SP dicantumkan per PB atau dijumlahkan ringkas).

---

## Ringkasan semua sprint

| Sprint | Tanggal (`+0800`) | Branch | Fokus sprint | PB utama (referensi cepat) |
|--------|-------------------|--------|--------------|----------------------------|
| 1 | 2026-03-03 | v1–v6 | Fondasi, auth, domain admin, laporan ODGJ awal & verifikasi | PB-001–012, PB-025–032 |
| 2 | 2026-03-04 | v7, v8 | Pasien CRUD & publik | PB-043–044 |
| 3 | 2026-03-05 | v9 | Riwayat pemeriksaan | PB-048 |
| 4 | 2026-03-06 | v10–v12 | Jadwal pasien, manajemen petugas (sesuai commit hari itu) | PB-049 *(inti)*; kerja terkait jadwal/notifikasi mengikuti branch |
| 5 | 2026-03-07 | v13, v14 | Pengingat jadwal & jadwal petugas (kalender, PDF, pola ulang) | PB-050, PB-053–059, PB-066 |
| 6 | 2026-03-08 | v15–v17 | Aktivitas pasien, jadwal rehabilitasi, stok/inventori | PB-045–047, PB-051–052, PB-060, PB-062–063 |
| 7 | 2026-03-09 | v18–v20 | Donasi Midtrans, stok expense, UI & dashboard | PB-033–039, PB-061, PB-064–065, PB-067, PB-072 |
| 8 | 2026-03-10 | v21, v22 | Admin users, seed, hardening & uji | PB-003 *(opsional)*, PB-006–007, PB-068–071, PB-073 |
| 9 | 2026-03-15 | v23 | CMS publik, web settings, transparansi & PDF | PB-013–024, PB-040–042 |

**PB yang belum terpetakan ke sprint harian di atas** (bisa masuk backlog berikutnya atau sprint Scrum 2 minggu): PB-003 (register opsional), PB-028, PB-038, PB-046, PB-057, PB-058, PB-066 (sebagian), PB-068 (opsional), dll. — sesuaikan dengan prioritas Product Owner.

---

## Sprint 1 — 2026-03-03 (`origin/v1` … `v6`)

**Sprint goal:** Fondasi keamanan & routing domain, autentikasi admin berperan, alur laporan ODGJ dari form publik hingga terima/tolak/respon email.

| No | Tugas (penyusunan kerja) | PB | SP |
|----|--------------------------|-----|-----|
| 1.1 | Rapikan `.env.example` (tanpa secret bawaan); dokumentasikan variabel wajib | *(fondasi repo)* | — |
| 1.2 | Konfigurasi domain publik vs admin (`Route::domain`), redirect login guest | PB-001 | 3 |
| 1.3 | Halaman login + `POST /login`, logout, flash error aman | PB-002 | 3 |
| 1.4 | Group route `middleware('guest'|'auth')` untuk area admin | PB-004 | 2 |
| 1.5 | RBAC (`users.role`), helper gate controller, respons 403/redirect | PB-005 | 5 |
| 1.6 | CRUD/manajemen user admin & petugas; update password | PB-006, PB-007 | 7 |
| 1.7 | Exception CSRF untuk callback Midtrans | PB-008 | 2 |
| 1.8 | Validasi input & sanitasi upload (form ODGJ + pola umum) | PB-009, PB-010 | 8 |
| 1.9 | Penanganan error SMTP/Midtrans + logging dasar | PB-011, PB-012 | 5 |
| 1.10 | Form publik laporan ODGJ (GET/POST), nomor laporan, upload gambar | PB-025 | 6 |
| 1.11 | Status awal `baru`, daftar & statistik dashboard | PB-026, PB-029 | 5 |
| 1.12 | Email ke petugas saat laporan baru; email terima kasih ke pelapor (opsional PB-028) | PB-027, PB-028 | 7 |
| 1.13 | Aksi terima/tolak + email konfirmasi; kirim `pesan_respon` | PB-030–032 | 9 |
| 1.14 | Tema UI gradasi & pemisahan layout publik vs admin | — (UX) | — |

---

## Sprint 2 — 2026-03-04 (`origin/v7`, `v8`)

**Sprint goal:** Data pasien lengkap di admin dan tampilan publik yang aman.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 2.1 | Migrasi/model `patients`, form CRUD, foto, filter pencarian | PB-043 | 7 |
| 2.2 | Notifikasi email create/update/delete pasien ke petugas | PB-043 | *(bagian)* |
| 2.3 | Halaman publik `/pasien` & detail tanpa data sensitif | PB-044 | 2 |
| 2.4 | Regresi ganda (v7 = v8): checklist sama untuk dua branch paralel | — | — |

---

## Sprint 3 — 2026-03-05 (`origin/v9`)

**Sprint goal:** Riwayat pemeriksaan terstruktur dan terintegrasi dashboard.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 3.1 | CRUD riwayat pemeriksaan, validasi field, pencarian nama pasien | PB-048 | 6 |
| 3.2 | Notifikasi email pada create/update/delete riwayat | PB-048 | *(bagian)* |
| 3.3 | Grafik/ringkasan dashboard terkait riwayat (sesuai implementasi) | — | — |

---

## Sprint 4 — 2026-03-06 (`origin/v10` … `v12`)

**Sprint goal:** Jadwal kunjungan pasien, notifikasi ke petugas, manajemen data petugas (user).

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 4.1 | CRUD jadwal pasien multi-`patient_ids`, validasi reminder, email saat perubahan | PB-049 | 7 |
| 4.2 | Penyesuaian show jadwal/laporan & perbaikan dashboard/views terkait | — | — |
| 4.3 | Manajemen petugas (field/migrasi), CRUD, notifikasi, PDF petugas jika ada | PB-016 *(overlap)*, PB-066 | 4+3 |

*Catatan:* Pengingat terjadwal ke pembimbing (**PB-050**) pada Product Backlog dipetakan ke **Sprint 5** di `sprint planning day.md`; jika commit v11 sudah mengimplementasi sebagian, sesuaikan tugas antar sprint tanpa menggandakan pekerjaan.

---

## Sprint 5 — 2026-03-07 (`origin/v13`, `v14`)

**Sprint goal:** Pengingat jadwal ganda & timezone; jadwal petugas (shift, kalender, bulk, libur, PDF).

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 5.1 | Command/scheduler pengingat: sebelum mulai + tepat mulai; kolom anti-duplikasi; timezone app | PB-050 | 5 |
| 5.2 | CRUD master shift | PB-053 | 4 |
| 5.3 | Index kalender + filter periode/user/shift; sembunyikan `jadwal_libur` | PB-054, PB-056 | 11 |
| 5.4 | Bulk create pola mingguan/2 minggu/bulanan; skip bentrok; laporan created/skipped | PB-055 | 8 |
| 5.5 | Jadwal pengganti (ganti shift) + notifikasi | PB-057 | 5 |
| 5.6 | CRUD jadwal petugas individual + update/destroy notifikasi | PB-059 | 4 |
| 5.7 | Ekspor PDF jadwal petugas | PB-058 | 4 |
| 5.8 | Ekspor PDF/Excel petugas (opsional) | PB-066 | 3 |

---

## Sprint 6 — 2026-03-08 (`origin/v15` … `v17`)

**Sprint goal:** Aktivitas pasien, jadwal rehabilitasi + PDF, modul stok & inventori inti.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 6.1 | CRUD aktivitas pasien (jenis, evaluasi, gambar, batch) | PB-045 | 6 |
| 6.2 | Store simple bulk banyak pasien + gambar | PB-046 | 4 |
| 6.3 | Duplikasi aktivitas | PB-047 | 2 |
| 6.4 | CRUD jadwal rehabilitasi + notifikasi petugas + `pembimbing_id` | PB-051 | 6 |
| 6.5 | Ekspor PDF jadwal rehabilitasi | PB-052 | 3 |
| 6.6 | Stock supply CRUD + gambar + perhitungan sisa | PB-060 | 6 |
| 6.7 | Inventory item + restock + transaksi `in` | PB-062 | 7 |
| 6.8 | Stock out + validasi tidak minus + transaksi `out` | PB-063 | 6 |

---

## Sprint 7 — 2026-03-09 (`origin/v18` … `v20`)

**Sprint goal:** Alur donasi Midtrans end-to-end, pengeluaran stok, perapihan UI, performa & UX flash.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 7.1 | Form donasi program + validasi | PB-033 | 5 |
| 7.2 | Simpan transaksi pending + `order_id` | PB-034 | 2 |
| 7.3 | Core API Midtrans + halaman bayar + QR | PB-035 | 6 |
| 7.4 | Polling status + redirect sukses | PB-036 | 4 |
| 7.5 | Webhook callback + idempotensi email thank-you | PB-037, PB-038 | 8 |
| 7.6 | Halaman sukses donasi | PB-039 | 2 |
| 7.7 | Pengeluaran stok (`DonationExpense` / supply–expense) | PB-061 | 5 |
| 7.8 | Notifikasi stok habis/hampir habis + ekspor CSV | PB-064, PB-065 | 8 |
| 7.9 | Pagination + eager loading index dashboard | PB-067 | 5 |
| 7.10 | Flash message konsisten CRUD | PB-072 | 2 |
| 7.11 | Iterasi UI dashboard, stok, laporan, donasi, form ODGJ | — | — |

---

## Sprint 8 — 2026-03-10 (`origin/v21`, `v22`)

**Sprint goal:** Akun admin & seeder, stabilitas rilis, uji integrasi & dokumentasi operasional.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 8.1 | User admin, SuperAdmin, dummy seeders; selaras model/migrasi/routes | PB-006 *(sebagian)* | — |
| 8.2 | Register admin opsional (jika kebijakan) | PB-003 | 2 |
| 8.3 | Audit log CRUD (opsional skripsi) | PB-068 | 5 |
| 8.4 | Black-box per modul (donasi, ODGJ, pasien, jadwal, stok) | PB-069 | 5 |
| 8.5 | Rencana & eksekusi uji Midtrans sandbox | PB-070 | 3 |
| 8.6 | Uji rendering PDF DomPDF (donasi, pengeluaran, jadwal) | PB-071 | 3 |
| 8.7 | Dokumentasi `MIDTRANS_*`, `MAIL_*`, callback, migrate, storage | PB-073 | 2 |
| 8.8 | Regresi ganda (v21 = v22) | — | — |

---

## Sprint 9 — 2026-03-15 (`origin/v23`)

**Sprint goal:** Situs publik: landing, CMS profil/visi-misi/struktur/layanan, pengaturan tampilan, transparansi donasi + PDF.

| No | Tugas | PB | SP |
|----|-------|-----|-----|
| 9.1 | CMS profil yayasan, visi-misi, struktur organisasi + foto | PB-013–015 | 15 |
| 9.2 | Petugas yayasan (daftar publik) | PB-016 | 4 |
| 9.3 | CRUD proses laporan ODGJ & tahapan rehabilitasi + halaman `/layanan` | PB-017 | 5 |
| 9.4 | Web settings warna teks/layout/background | PB-018–020 | 14 |
| 9.5 | Beranda + CTA donasi per program | PB-021 | 3 |
| 9.6 | Galeri aktivitas pasien (filter gambar) | PB-022 | 3 |
| 9.7 | Halaman kontak, cara donasi, mitra, FAQ | PB-023 | 3 |
| 9.8 | Profil/struktur konsisten & performa query | PB-024 | 2 |
| 9.9 | Dashboard transparansi donasi + paginasi | PB-040 | 6 |
| 9.10 | PDF laporan donasi & pengeluaran | PB-041, PB-042 | 10 |
| 9.11 | Refactor view publik konsisten | — | — |

---

## Definisi selesai per tugas (sinkron DoD Product Backlog)

1. Alur fitur jelas end-to-end (UI, validasi, status bila ada).  
2. Email/PDF sesuai scope tugas berfungsi dan teruji manual atau otomatis.  
3. Tidak meregresi modul lain pada skenario seed/default.

---

## Pemeliharaan dokumen

- Setelah `git fetch` dan perubahan tanggal tip branch `origin/v*`, perbarui tabel ringkasan mengikuti `sprint planning day.md`.  
- Jika Product Owner mengubah prioritas PB, sesuaikan baris tugas dan nomor sprint tanpa menghapus riwayat (bisa pindahkan ke catatan revisi).
