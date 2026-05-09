# BAB III METODOLOGI PENELITIAN

## A.  Objek, Lokasi, Subjek, dan Waktu Penelitian

Objek penelitian ini adalah Yayasan Griya Satu Mimika sebagai lembaga yang menangani kegiatan sosial, donasi, serta layanan rehabilitasi ODGJ berbasis komunitas. Lokasi penelitian dilaksanakan di kantor operasional yayasan yang beralamat di Jl. Cenderawasih No. 18, Mimika, Papua Tengah (data dummy). Subjek penelitian terdiri dari 6 narasumber wawancara, yaitu ketua yayasan, sekretaris, bendahara, koordinator rehabilitasi, petugas lapangan, dan admin sistem, serta 25 responden SUS dari staf dan pengguna publik. Waktu penelitian dilaksanakan selama Januari sampai Mei 2026 dengan pembagian tahap analisis, pengembangan perangkat lunak berbasis Scrum, implementasi, dan evaluasi.

## B.  Jenis dan Pendekatan Penelitian

Penelitian ini menggunakan jenis penelitian pengembangan (research and development) karena menghasilkan produk berupa sistem informasi yayasan berbasis web terintegrasi. Pendekatan yang digunakan adalah campuran kualitatif dan kuantitatif agar proses analisis kebutuhan serta evaluasi hasil dapat dilakukan secara seimbang. Pendekatan kualitatif diterapkan melalui wawancara dengan pengurus yayasan untuk menggali proses bisnis dan masalah operasional yang berjalan. Pendekatan kuantitatif diterapkan melalui pengukuran kegunaan sistem menggunakan instrumen System Usability Scale (SUS) pada pengguna akhir.



## C.  Metode Pengumpulan Data

Metode pengumpulan data dalam penelitian ini menggunakan kombinasi wawancara, studi dokumentasi, observasi, dan kuesioner SUS untuk mendapatkan data yang komprehensif. Wawancara digunakan untuk memetakan kebutuhan fitur sesuai aktivitas nyata yayasan pada layanan publik dan dashboard admin. Studi dokumentasi dilakukan untuk meninjau arsip operasional yayasan dan artefak teknis proyek Laravel yang dikembangkan. Observasi serta SUS digunakan untuk memvalidasi kesesuaian proses kerja dan tingkat kemudahan penggunaan sistem setelah implementasi.

### 1.  Wawancara (analisis kebutuhan dan masalah)

Wawancara dilakukan secara semi-terstruktur kepada pihak internal yayasan agar kebutuhan sistem dapat digali secara mendalam namun tetap fokus pada tujuan penelitian. Topik wawancara mencakup alur laporan ODGJ online, validasi laporan, proses tindak lanjut petugas, dan kebutuhan notifikasi email untuk mempercepat respons. Wawancara juga membahas kebutuhan modul donasi QRIS, transparansi donasi publik, manajemen data pasien, jadwal, stok, serta pengelolaan konten CMS. Hasil wawancara dirangkum dalam bentuk matriks kebutuhan fungsional dan nonfungsional yang kemudian menjadi dasar penyusunan *product backlog* Scrum.

### 2. Studi dokumentasi

Studi dokumentasi dilakukan dengan menelaah dokumen internal yayasan seperti catatan donasi, data laporan masyarakat, data pasien, serta format pelaporan operasional bulanan. Pada sisi teknis, dokumentasi juga mencakup peninjauan struktur rute Laravel, skema basis data, serta catatan integrasi pembayaran Midtrans QRIS dan pengiriman email notifikasi. Dokumen yang dianalisis dipilih berdasarkan relevansinya terhadap lima modul utama penelitian yaitu laporan ODGJ, donasi, transparansi, manajemen data, dan CMS. Seluruh data sensitif seperti token API, kata sandi, dan identitas pribadi disamarkan untuk menjaga keamanan dan etika penelitian.

### 3. Observasi (opsional)

Observasi dilakukan terhadap alur kerja harian pengurus yayasan sebelum sistem diterapkan untuk memahami hambatan proses manual yang masih terjadi. Peneliti mencatat bahwa pencatatan laporan ODGJ dan donasi sebelumnya tersebar pada media pesan instan dan lembar spreadsheet terpisah sehingga sulit dipantau secara real time. Observasi lanjutan dilakukan setelah implementasi untuk melihat perubahan efisiensi ketika proses berpindah ke halaman publik dan dashboard terpusat. Hasil observasi menunjukkan bahwa waktu rekap data mingguan menurun dari rata-rata 180 menit menjadi 65 menit (data dummy).

### 4. Kuesioner System Usability Scale (SUS)

Kuesioner SUS diberikan kepada 25 responden yang sudah mencoba fitur utama sistem, terdiri dari 15 pengguna internal dashboard dan 10 pengguna publik untuk layanan laporan serta donasi. Instrumen yang digunakan adalah 10 pernyataan standar SUS dengan skala Likert 1 sampai 5 dan formulir dibagikan setelah sesi uji tugas selesai. Pengumpulan data dilakukan secara anonim setelah responden menyatakan persetujuan berpartisipasi untuk menjaga etika penelitian. Hasil akhir perhitungan menghasilkan skor rata-rata SUS sebesar 79,2 yang termasuk kategori baik dan berada di atas nilai rata-rata standar 68 (data dummy).

## D.  Metode Pengembangan Perangkat Lunak: Scrum

Metode pengembangan perangkat lunak yang digunakan adalah **Scrum**, yaitu kerangka kerja dalam keluarga *Agile* yang mengorganisir pekerjaan dalam iterasi berdurasi tetap bernama **sprint**. Dalam penelitian ini setiap sprint berlangsung **dua minggu** agar kebutuhan yayasan dapat diprioritaskan ulang secara berkala dan hasil kerja dapat direview secara rutin.

**Peran Scrum** disesuaikan dengan skala proyek skripsi: **Product Owner** diwakili oleh pihak pengurus yayasan (atau perwakilan yang memahami prioritas layanan) yang menyetujui urutan *product backlog* dan menerima *increment* di akhir sprint; **Scrum Master** diemban peneliti untuk memfasilitasi perencanaan, menghapus hambatan proses, dan menjaga ritme sprint; **Development Team** terdiri dari peneliti sebagai pengembang utama yang mengimplementasikan *sprint backlog* menjadi perangkat lunak yang teruji.

**Artefak Scrum** yang dipakai meliputi ***product backlog*** berisi daftar kebutuhan fitur yang diperoleh dari wawancara dan dokumentasi; ***sprint backlog*** berupa subset pekerjaan yang dipilih untuk satu sprint; dan ***increment*** berupa versi perangkat lunak yang dapat diuji dan didemokan pada akhir sprint.

**Acara Scrum** meliputi ***sprint planning*** untuk memilih item backlog dan merencanakan pekerjaan sprint; ***daily scrum*** berupa sinkronisasi singkat harian (status, hambatan, rencana hari itu) guna menjaga transparansi progres; ***sprint review*** bersama Product Owner untuk mendemokan increment dan mengumpulkan umpan balik; serta ***sprint retrospective*** untuk mengevaluasi proses sprint dan perbaikan cara kerja pada sprint berikutnya.

Secara substansi, urutan pengerjaan mengikuti prioritas backlog: fondasi autentikasi admin dan pemisahan domain publik–admin, modul CMS konten yayasan, modul laporan ODGJ online, donasi QRIS dengan callback Midtrans, modul transparansi donasi termasuk keluaran PDF, lalu manajemen data operasional (pasien, jadwal, petugas, stok). Umpan balik dari *sprint review* memandu penyesuaian prioritas sprint berikutnya hingga seluruh fitur inti terpenuhi.

## E. Tahapan Penelitian / Alur Kerja

Tahapan penelitian dimulai dari analisis kebutuhan melalui wawancara dan dokumentasi untuk menetapkan ruang lingkup fitur yang benar-benar dibutuhkan yayasan. Setelah kebutuhan disepakati, peneliti menyusun desain arsitektur, basis data, antarmuka, dan skenario keamanan sebagai pedoman implementasi bertahap. Proses implementasi dilakukan menggunakan Laravel pada lingkungan pengembangan lokal dan server uji dengan pemisahan layanan domain publik serta dashboard admin. Tahap terakhir adalah pengujian fungsional, pengujian integrasi layanan pihak ketiga, serta evaluasi kegunaan menggunakan SUS untuk menilai kualitas sistem.

### 1.  Analisis kebutuhan dan masalah

Analisis kebutuhan dilakukan dengan mengidentifikasi masalah utama, yaitu lambatnya verifikasi laporan ODGJ, pencatatan donasi yang tersebar, dan minimnya media transparansi publik. Hasil analisis menunjukkan kebutuhan sistem yang dapat menampung pelaporan online, notifikasi petugas, status tindak lanjut laporan, dan pelacakan donasi secara terstruktur. Kebutuhan lainnya adalah dashboard operasional untuk mengelola data pasien, jadwal rehabilitasi, jadwal petugas, stok logistik, serta konten profil yayasan secara mandiri. Seluruh kebutuhan dipetakan menjadi prioritas backlog berdasarkan dampak layanan dan urgensi implementasi bagi yayasan.

### 2. Perancangan sistem

Perancangan sistem menggunakan arsitektur client-server dengan dua domain layanan yaitu domain publik untuk pengguna umum dan domain admin untuk pengelolaan internal berbasis autentikasi. Desain basis data memuat entitas inti seperti laporan ODGJ, donasi, pengeluaran donasi, pasien, jadwal, stok, pengguna admin, dan konten CMS agar data dapat saling terhubung. Desain antarmuka dibuat untuk halaman penting seperti beranda, form laporan ODGJ, form donasi dan pembayaran QRIS, halaman transparansi, serta modul dashboard manajemen data. Aspek keamanan dirancang dengan kontrol otorisasi peran, validasi input, perlindungan data sensitif, dan mekanisme verifikasi callback pembayaran.

### 3. Implementasi

Implementasi sistem dilakukan menggunakan Laravel 12, PHP 8.3, MySQL, Blade template, dan Vite sebagai bundler aset frontend (data dummy menyesuaikan lingkungan proyek). Modul pertama yang dibangun adalah CMS dan konten publik, meliputi pengaturan web, profil yayasan, visi-misi, struktur organisasi, dan konten layanan. Modul berikutnya mencakup laporan ODGJ online dengan unggah bukti, notifikasi email, serta pengelolaan status diterima, ditolak, dan respon melalui dashboard. Modul donasi QRIS, transparansi donasi berbasis PDF, dan manajemen data operasional kemudian diselesaikan hingga seluruh fitur inti berjalan terintegrasi.

### 4. Pengujian dan evaluasi

Pengujian fungsional dilakukan dengan metode black box pada 32 skenario uji yang mencakup alur submit laporan, verifikasi admin, donasi, callback pembayaran, hingga publikasi transparansi donasi (data dummy). Pengujian integrasi difokuskan pada sinkronisasi status transaksi Midtrans QRIS, pengiriman email notifikasi, dan pembangkitan dokumen PDF agar konsisten dengan data dashboard. Hasil pengujian menunjukkan 30 skenario dinyatakan berhasil, 2 skenario memerlukan perbaikan minor pada validasi formulir dan pesan umpan balik antarmuka. Setelah perbaikan diterapkan, evaluasi SUS dilakukan untuk memastikan sistem nyaman digunakan oleh pengguna internal maupun publik.

