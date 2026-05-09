# Increment/Development (Pengerjaan dan Hasil)

## Sprint 1
**Sprint:** 1  
**Tanggal acuan:** 2026-03-03  
**Branch/Komit:** `origin/v1–v6` (tip v6: `e4e82a7`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 1, saya mengembangkan fondasi aplikasi sekaligus keamanan akses dengan pemisahan area publik dan admin menggunakan `Route::domain`, konfigurasi autentikasi serta kontrol peran (RBAC) untuk akses dashboard admin/petugas. Saya juga menyiapkan alur workflow laporan ODGJ dari form publik sampai pengelolaan status laporan (terima/tolak) dan pengiriman email respon kepada pihak terkait, termasuk penanganan error SMTP/Midtrans serta validasi input dan sanitasi upload agar proses pelaporan berjalan stabil.

## Hasil
Hasil Sprint 1 adalah sistem yang sudah memiliki akses admin berbasis peran, alur laporan ODGJ yang end-to-end dari publik hingga keputusan admin, serta notifikasi email sebagai penguat komunikasi. Dengan fondasi keamanan dan workflow inti tersebut, sprint berikutnya bisa membangun modul operasional lanjutan tanpa mengubah dasar alur utama.

---

## Sprint 2
**Sprint:** 2  
**Tanggal acuan:** 2026-03-04  
**Branch/Komit:** `origin/v7–v8` (tip v7: `1be0862`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 2, saya mengembangkan manajemen data pasien melalui CRUD pada area admin, termasuk penyimpanan foto identitas, filter pencarian, serta penyesuaian tampilan agar data sensitif tidak terekspos ke publik. Selain itu, saya mengimplementasikan notifikasi email ketika data pasien dibuat/diperbarui/dihapus agar petugas menerima informasi terkini. Halaman publik pasien (`/pasien`) dan detailnya disusun dengan prinsip keamanan data (publik hanya menampilkan informasi yang diperbolehkan).

## Hasil
Hasil Sprint 2 adalah tersedianya modul pasien yang lengkap untuk mendukung proses rehabilitasi, sekaligus menyediakan halaman publik pasien yang aman dan informatif. Karena adanya notifikasi email, petugas dapat merespons perubahan data pasien lebih cepat.

---

## Sprint 3
**Sprint:** 3  
**Tanggal acuan:** 2026-03-05  
**Branch/Komit:** `origin/v9` (commit `6e22426`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 3, saya membangun modul riwayat pemeriksaan pasien dengan CRUD yang terstruktur per pasien, termasuk validasi field dan dukungan pencarian. Saya juga mengintegrasikan notifikasi email untuk peristiwa create/update/delete riwayat pemeriksaan. Di sisi tampilan, saya menyiapkan ringkasan/dashboard terkait riwayat agar informasi pemeriksaan mudah dipantau.

## Hasil
Hasil Sprint 3 adalah riwayat pemeriksaan yang tersimpan dan dapat dikelola secara sistematis untuk tiap pasien, disertai notifikasi agar petugas selalu mendapatkan pembaruan. Dashboard yang terintegrasi membuat progres pemeriksaan lebih mudah dipahami.

---

## Sprint 4
**Sprint:** 4  
**Tanggal acuan:** 2026-03-06  
**Branch/Komit:** `origin/v10–v12` (tip v12: `6f7f84f`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 4, saya mengembangkan modul jadwal kunjungan pasien dengan CRUD untuk relasi multi-`patient_ids` serta validasi reminder (pengingat) agar pengingat tidak salah waktu. Saya juga menyiapkan notifikasi email ketika jadwal pasien berubah, lalu melakukan penyesuaian pada tampilan show jadwal dan dashboard/views terkait agar sinkron dengan data jadwal yang baru.

Selain itu, saya menguatkan manajemen data petugas (CRUD, migrasi/field yang dibutuhkan, notifikasi), serta menyiapkan ruang untuk ekspor PDF petugas apabila diperlukan dalam alur yang sedang berjalan.

## Hasil
Hasil Sprint 4 adalah tersedianya sistem jadwal kunjungan pasien yang terhubung dengan notifikasi, sehingga petugas/pembimbing dapat merespons perubahan jadwal lebih cepat. Manajemen petugas yang diperkuat juga membuat pengaturan jadwal menjadi lebih rapi dan terarah.

---

## Sprint 5
**Sprint:** 5  
**Tanggal acuan:** 2026-03-07  
**Branch/Komit:** `origin/v13–v14` (tip v14: `dda38f7`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 5, saya mengimplementasikan scheduler/command pengingat jadwal agar pengingat dikirim sebelum mulai dan tepat waktu saat jadwal dimulai. Saya memastikan adanya kolom anti-duplikasi serta penerapan timezone agar waktu pengingat akurat. Setelah itu, saya membangun modul jadwal petugas: master shift, index kalender dengan filter periode/user/shift, kemampuan bulk create pola jadwal (mingguan/2 minggu/bulanan) dengan mekanisme skip bentrok, serta pengaturan jadwal pengganti (ganti shift) beserta notifikasinya.

Saya lanjutkan dengan penyusunan CRUD jadwal petugas individual dan pengelolaan notifikasi terkait, termasuk ekspor PDF jadwal petugas (dan opsi ekspor tambahan bila dibutuhkan).

## Hasil
Hasil Sprint 5 adalah sistem pengingat jadwal yang lebih dapat dipercaya, jadwal petugas yang bisa dibangun secara massal dan tetap aman dari bentrok, serta tersedianya kalender dan ekspor PDF untuk kebutuhan monitoring dan arsip.

---

## Sprint 6
**Sprint:** 6  
**Tanggal acuan:** 2026-03-08  
**Branch/Komit:** `origin/v15–v17` (tip v17: `1afa5c8`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 6, saya mengembangkan modul aktivitas pasien dengan CRUD (jenis, evaluasi, gambar, dan kemampuan batch) serta menangani kasus duplikasi aktivitas agar data tidak tercatat berulang secara tidak perlu. Selanjutnya, saya membangun jadwal rehabilitasi dengan CRUD, notifikasi ke petugas, dukungan `pembimbing_id`, serta ekspor PDF. Saya juga menambahkan kalender mingguan agar tampilan jadwal rehabilitasi lebih mudah dipantau.

Di sisi operasional, saya mengembangkan modul stok/inventori: mulai dari CRUD stock supply (termasuk gambar dan perhitungan sisa), pengelolaan inventory item dengan restock dan transaksi `in`, hingga stock out dengan validasi agar stok tidak minus serta transaksi `out` yang konsisten.

## Hasil
Hasil Sprint 6 adalah data aktivitas dan rehabilitasi yang tercatat dengan baik serta jadwal yang dapat ditelusuri, disertai output PDF untuk kebutuhan pelaporan. Modul stok/inventori juga membuat alur operasional yayasan memiliki mekanisme pencatatan supply–expense yang lebih terstruktur.

---

## Sprint 7
**Sprint:** 7  
**Tanggal acuan:** 2026-03-09  
**Branch/Komit:** `origin/v18–v20` (tip v20: `24ebf63`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 7, saya mengimplementasikan end-to-end donasi berbasis Midtrans QRIS: form donasi dengan validasi, penyimpanan transaksi pending beserta `order_id`, integrasi core API Midtrans, halaman bayar dengan QR, polling status sampai redirect sukses, serta webhook callback yang memastikan idempotensi (email terima kasih tidak duplikat). Saya juga menyiapkan halaman sukses donasi sebagai bukti transaksi.

Selain donasi, saya mengembangkan pengeluaran stok melalui modul `DonationExpense`/supply-expense, lalu menambahkan notifikasi ketika stok habis atau hampir habis serta ekspor CSV stok. Saya juga meningkatkan performa halaman dashboard melalui pagination dan eager loading, lalu menyamakan flash message agar konsisten di setiap CRUD serta melakukan iterasi UI untuk modul-modul terkait.

## Hasil
Hasil Sprint 7 adalah alur donasi QRIS yang utuh dan konsisten dari form sampai callback, disertai pengelolaan pengeluaran stok dan peningkatan tampilan dashboard. Pengunjung dan admin menjadi lebih terbantu karena sistem transaksi dan informasi stok lebih rapi serta responsif.

---

## Sprint 8
**Sprint:** 8  
**Tanggal acuan:** 2026-03-10  
**Branch/Komit:** `origin/v21–v22` (commit `d90353e`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 8, saya melakukan hardening sistem pada sisi admin dengan pengembangan user admin, SuperAdmin, dummy seeders, serta penyesuaian model/migrasi/views/routes agar struktur aplikasi lebih stabil. Saya melanjutkan dengan pengujian black-box per modul (donasi, ODGJ, pasien, jadwal, stok) untuk memastikan tidak ada regresi.

Selanjutnya saya menyusun rencana dan eksekusi pengujian Midtrans sandbox, melakukan uji rendering PDF menggunakan DomPDF untuk donasi/pengeluaran/jadwal, serta merapikan dokumentasi operasional terkait `MIDTRANS_*`, `MAIL_*`, callback, migrate, dan storage agar proses deployment dan pengujian lanjutan lebih mudah.

## Hasil
Hasil Sprint 8 adalah sistem yang lebih siap rilis karena sudah melewati tahap hardening, pengujian integrasi dan PDF rendering, serta terdokumentasinya komponen penting untuk operasi admin. Dengan begitu, Sprint 9 dapat fokus pada penyempurnaan sisi publik dan transparansi.

---

## Sprint 9
**Sprint:** 9  
**Tanggal acuan:** 2026-03-15  
**Branch/Komit:** `origin/v23` (commit `b3112d4`)  
**Referensi:** `product backlog.md`, `sprint planning.md`, `sprint backlog.md`

## Pengerjaan
Pada Sprint 9, saya mengembangkan modul CMS publik untuk area profil yayasan (profil yayasan, visi-misi, struktur organisasi, data petugas, dan layanan). Saya menambahkan pengaturan visual melalui `web settings` untuk warna heading (h1-h6), paragraf, span, serta warna div/A dan tombol, kemudian menyusun background global versus per halaman yang mendukung mode `warna` dan `gambar` dengan penerapan overlay opacity secara konsisten.

Selanjutnya, saya menyusun halaman publik utama: beranda + CTA donasi, galeri aktivitas pasien berdasarkan field `image`, serta halaman informasi (kontak, cara donasi, mitra, dan FAQ). Agar konten tetap relevan, saya memastikan halaman publik membaca data terbaru dan penggabungan/urutan data konsisten tanpa menimbulkan N+1 signifikan pada area profil/struktur.

Pada bagian transparansi donasi, saya mengimplementasikan dashboard publik (ringkasan dan daftar) serta fitur ekspor PDF untuk laporan donasi maupun pengeluaran. Terakhir, saya melakukan refactor view publik agar konsisten dan tahan terhadap kondisi konten yang kosong atau bersifat dinamis.

## Hasil
Hasil Sprint 9 adalah situs publik yang lebih lengkap karena konten yayasan dapat dikelola dari admin dan langsung tercermin pada halaman publik. Website juga menjadi lebih mudah disesuaikan tampilannya melalui `web settings`, sementara alur informasi publik lebih jelas dan dapat diakses tanpa autentikasi. Transparansi donasi tersaji dalam dashboard ringkas, daftar dengan paginasi berdasarkan status, serta dokumen PDF untuk kebutuhan arsip dan pelaporan. Secara keseluruhan, refactor view publik meningkatkan konsistensi layout sekaligus ketahanan terhadap konten dinamis/kosong.

