# Sprint Planning Day — Satu Sprint per Hari (Kalender)

**Produk:** Sistem Informasi Yayasan Griya Satu Mimika.  
**Aturan penggabungan:** Semua branch `origin/v*` yang **commit tip-nya jatuh pada tanggal kalender yang sama** (menurut **committer date**, zona `+0800`) digabung menjadi **satu sprint**.  
**Hasil:** Dari **23 branch** menjadi **9 sprint harian** (ada jeda tanggal antara 2026-03-10 dan 2026-03-15).  
**Catatan:** Ini sprint berbasis **hari kerja Git**, bukan Sprint 0–6 di `product backlog.md`.

**Perintah verifikasi ulang:**

```bash
git fetch origin
git for-each-ref --sort=committerdate \
  --format='%(refname:short)|%(committerdate:iso8601)|%(objectname:short)|%(contents:subject)' \
  refs/remotes/origin/v*
```

---

## Ringkasan: sprint per hari

| Sprint | Tanggal (kalender) | Jumlah branch | Branch (urut waktu dalam hari) |
|--------|-------------------|---------------|--------------------------------|
| 1 | 2026-03-03 | 6 | v1 → v2 → v3 → v4 → v5 → v6 |
| 2 | 2026-03-04 | 2 | v7, v8 *(commit sama)* |
| 3 | 2026-03-05 | 1 | v9 |
| 4 | 2026-03-06 | 3 | v10 → v11 → v12 |
| 5 | 2026-03-07 | 2 | v13 → v14 |
| 6 | 2026-03-08 | 3 | v15 → v16 → v17 |
| 7 | 2026-03-09 | 3 | v18 → v19 → v20 |
| 8 | 2026-03-10 | 2 | v21, v22 *(commit sama)* |
| 9 | 2026-03-15 | 1 | v23 |

---

## Tabel detail per sprint (semua tonggak dalam hari itu)

### Sprint 1 — 3 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 11:29:10 | origin/v1 | 0a6d2c8 | Update .env.example - remove sensitive keys |
| 21:18:59 | origin/v2 | 8fe9dec | Add authentication system with role-based dashboard |
| 22:23:37 | origin/v3 | 5840bad | feat: Pelaporan ODGJ - form, notifikasi email, dashboard, upload gambar dengan kamera, fix error 413 |
| 23:09:56 | origin/v4 | c030863 | Tema gradasi biru muda & dashboard terpisah |
| 23:20:43 | origin/v5 | ec5b3c7 | Domain admin admin.griyasatumimika.web.id - Login wajib sebelum dashboard |
| 23:46:16 | origin/v6 | e4e82a7 | feat: email respon laporan ODGJ & tombol terima/tolak di dashboard |

**Nama sprint (fokus gabungan):** Fondasi, autentikasi, ODGJ awal, tema, domain admin, workflow verifikasi laporan.

**Fokus pengerjaan (gabungan):**

- Keamanan template `.env.example` tanpa secret bawaan.
- Login, dashboard berbasis peran, middleware/domain admin terpisah.
- Form laporan ODGJ publik, upload, notifikasi, dashboard daftar laporan; lalu tema UI dan pemisahan layout publik vs admin.
- Penyelesaian hari: terima/tolak laporan dan email respon ODGJ.

**Backlog yang tercakup (Product Backlog):**

- `PB-001–PB-012` (Fondasi & Keamanan)
- `PB-025–PB-032` (Laporan ODGJ Workflow)

---

### Sprint 2 — 4 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 23:15:47 | origin/v7 | 1be0862 | Fit: Data Pasien - CRUD, foto identitas, notifikasi email, grafik dashboard |
| 23:15:47 | origin/v8 | 1be0862 | *(identik dengan v7)* |

**Nama sprint (fokus gabungan):** Manajemen data pasien & dashboard.

**Fokus pengerjaan (gabungan):**

- CRUD pasien, foto identitas, notifikasi email, grafik ringkas di dashboard.
- `v8` = titik commit sama dengan `v7`: verifikasi ganda / jalur branch paralel, checklist regresi yang sama.

**Backlog yang tercakup (Product Backlog):**

- `PB-043–PB-044` (CRUD pasien + halaman publik pasien)

---

### Sprint 3 — 5 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 00:43:26 | origin/v9 | 6e22426 | feat: riwayat pemeriksaan pasien & grafik dashboard |

**Nama sprint (fokus gabungan):** Riwayat pemeriksaan pasien.

**Fokus pengerjaan (gabungan):**

- CRUD riwayat pemeriksaan per pasien; integrasi grafik dashboard; pencarian/filter sesuai implementasi.

**Backlog yang tercakup (Product Backlog):**

- `PB-048` (CRUD riwayat pemeriksaan)

---

### Sprint 4 — 6 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 10:21:35 | origin/v10 | 571d176 | feat: jadwal pasien & notifikasi email ke petugas |
| 23:11:02 | origin/v11 | de6e739 | feat: pengingat jadwal pasien ke pembimbing |
| 23:15:41 | origin/v12 | 6f7f84f | feat: manajemen petugas & notifikasi email |

**Nama sprint (fokus gabungan):** Jadwal pasien, pengingat pembimbing & manajemen petugas.

**Fokus pengerjaan (gabungan):**

- Jadwal kunjungan pasien + email ke petugas saat perubahan jadwal.
- Pengingat email ke pembimbing; UI dashboard terkait jadwal.
- Manajemen petugas (field user/migrasi), CRUD, notifikasi email, ekspor PDF petugas bila ada.

**Backlog yang tercakup (Product Backlog):**

- `PB-049` (CRUD jadwal pasien)

---

### Sprint 5 — 7 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 00:16:36 | origin/v13 | 387855b | feat: pengingat jadwal ganda & penyesuaian timezone |
| 23:29:04 | origin/v14 | dda38f7 | feat: Jadwal Petugas - kalender bulanan, export PDF download, hapus Excel |

**Nama sprint (fokus gabungan):** Pengingat lanjutan & jadwal petugas (kalender + PDF).

**Fokus pengerjaan (gabungan):**

- Pengingat ganti hari sebelum mulai + tepat waktu mulai; kolom anti-duplikasi; timezone aplikasi.
- Kalender bulanan jadwal petugas, export PDF, penyederhanaan ekspor Excel.

**Backlog yang tercakup (Product Backlog):**

- `PB-050` (Pengingat jadwal pasien ke pembimbing)
- `PB-053–PB-059` (Jadwal petugas: shift master, kalender/filter, bulk berulang, libur, pengganti, CRUD individual)
- `PB-066` (Ekspor PDF/Petugas - opsional)

---

### Sprint 6 — 8 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 00:58:31 | origin/v15 | 0edef47 | Tambah halaman aktivitas pasien: form sederhana, multi foto, tabel per aktivitas |
| 20:58:44 | origin/v16 | 576c18a | feat: Jadwal Rehabilitasi - CRUD, notifikasi email petugas, export PDF, kalender mingguan |
| 23:30:06 | origin/v17 | 1afa5c8 | Add stock/inventory module, migrations, and UI updates |

**Nama sprint (fokus gabungan):** Aktivitas pasien, jadwal rehabilitasi & modul stok.

**Fokus pengerjaan (gabungan):**

- Aktivitas pasien: form, multi-foto, tabel/batch.
- Jadwal rehabilitasi: CRUD, email petugas, PDF, kalender mingguan, statistik.
- Stok/inventori: migrasi, UI, transaksi dasar.

**Backlog yang tercakup (Product Backlog):**

- `PB-045–PB-047` (Aktivitas pasien: CRUD, store simple, duplikasi)
- `PB-051–PB-052` (Jadwal rehabilitasi + ekspor PDF)
- `PB-060` (Stock supply CRUD + gambar)
- `PB-062–PB-063` (Inventory item + restock, stock out + validasi stok tidak minus)

---

### Sprint 7 — 9 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 04:01:25 | origin/v18 | 1ac1cea | Update: donasi pengeluaran, stock supply/expense, ODGJ report email, jadwal pasien show, laporan show, dan perbaikan dashboard/views |
| 21:14:15 | origin/v19 | 76b9bc9 | Update UI dashboard, stok, laporan, donasi, dan form laporan ODGJ |
| 22:38:14 | origin/v20 | 24ebf63 | Update UI dashboard, stok, donasi, dan laporan |

**Nama sprint (fokus gabungan):** Donasi–pengeluaran, stok supply/expense, perapihan modul & UI operasional.

**Fokus pengerjaan (gabungan):**

- Pengeluaran donasi, supply/expense stok, perbaikan email ODGJ, halaman detail jadwal/laporan, konsistensi dashboard.
- Dua iterasi penyegaran UI: dashboard, stok, laporan, donasi, form ODGJ.

**Backlog yang tercakup (Product Backlog):**

- `PB-033–PB-039` (Donasi QRIS Midtrans + halaman sukses)
- `PB-061` (Stok pengeluaran)
- `PB-064–PB-065` (Notifikasi stok + ekspor CSV stok)
- `PB-067` (Performa index dashboard)
- `PB-072` (UX flash messages untuk semua CRUD)

---

### Sprint 8 — 10 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 11:09:50 | origin/v21 | d90353e | Update: Admin users, seeders (SuperAdmin, DummyData), models, migrations, views, dan routes |
| 11:09:50 | origin/v22 | d90353e | *(identik dengan v21)* |

**Nama sprint (fokus gabungan):** Akun admin, seeder data & struktur aplikasi.

**Fokus pengerjaan (gabungan):**

- User admin, SuperAdmin & dummy seeders, selaras model/migrasi/view/routes.
- `v22` = commit sama `v21`: gate rilis, regresi dengan seed, cek migrate/storage/mail.

**Backlog yang tercakup (Product Backlog):**

- `PB-068` (Audit log CRUD - opsional)
- `PB-069` (Pengujian black-box per modul)
- `PB-070` (Pengujian integrasi Midtrans)
- `PB-071` (Pengujian PDF rendering)
- `PB-073` (Dokumentasi operasional admin Midtrans/SMTP)

---

### Sprint 9 — 15 Maret 2026 (`+0800`)

| Waktu | Branch | Commit | Subjek |
|-------|--------|--------|--------|
| 00:54:41 | origin/v23 | b3112d4 | Update: fitur public landing, profil yayasan, visi-misi, layanan, transparansi donasi, dan refactor views |

**Nama sprint (fokus gabungan):** Situs publik, konten yayasan & transparansi donasi.

**Fokus pengerjaan (gabungan):**

- Landing, profil, visi-misi, layanan, halaman transparansi donasi, refactor view publik.

**Backlog yang tercakup (Product Backlog):**

- `PB-013–PB-024` (CMS konten publik + web settings)
- `PB-040–PB-042` (Transparansi donasi: dashboard + ekspor PDF donasi/pengeluaran)

---

## Garis waktu sprint harian

```
2026-03-03  Sprint 1  (6 branch: v1–v6)
2026-03-04  Sprint 2  (v7, v8)
2026-03-05  Sprint 3  (v9)
2026-03-06  Sprint 4  (v10–v12)
2026-03-07  Sprint 5  (v13, v14)
2026-03-08  Sprint 6  (v15–v17)
2026-03-09  Sprint 7  (v18–v20)
2026-03-10  Sprint 8  (v21, v22)
   … jeda tidak ada commit tip baru pada tanggal lain …
2026-03-15  Sprint 9  (v23)
```

---

*Setelah `git fetch` atau jika commit tip branch berpindah tanggal, kelompokkan ulang per hari dengan perintah di atas lalu sesuaikan tabel ini.*
