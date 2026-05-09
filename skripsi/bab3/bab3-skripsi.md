# Struktur Bab III Metodologi Penelitian


## BAB III METODOLOGI PENELITIAN

### 1 Objek, Lokasi, Subjek, dan Waktu Penelitian

**Isi yang disarankan**

- **Objek penelitian**: Yayasan Griya Satu Mimika sebagai organisasi pengelola layanan rehabilitasi dan kegiatan sosial terkait ODGJ.
- **Lokasi**: kantor/operasional yayasan (sesuaikan alamat resmi pada dokumen lembaga).
- **Subjek**:
  - **Narasumber wawancara**: pihak pengurus/pengelola (mis. sekretaris, bendahara, koordinator rehabilitasi, petugas lapangan) sesuai kewenangan data.
  - **Responden SUS**: pengguna akhir yang relevan—mis. staf admin/petugas dashboard, dan/atau perwakilan donatur/warga pengguna form laporan (sesuaikan dengan etik penelitian dan akses yang diizinkan yayasan).
- **Waktu penelitian**: rentang periode pengumpulan data, sprint Scrum, dan pengujian (isi tanggal konkret).

---


### 2 Jenis dan Pendekatan Penelitian

**Isi yang disarankan**

- Nyatakan jenis penelitian: **penelitian pengembangan** (*research and development* / rekayasa perangkat lunak) dengan menghasilkan artefak sistem informasi berbasis web.
- Pendekatan: **kuantitatif–kualitatif campuran** (opsional namun umum untuk skripsi TI):
  - **Kualitatif**: wawancara mendalam untuk kebutuhan, konteks yayasan, dan pemetaan masalah.
  - **Kuantitatif**: skor **System Usability Scale (SUS)** dari responden pengujian.
- Hubungkan dengan judul: fokus pada **perancangan + implementasi** terintegrasi (laporan ODGJ online, donasi QRIS, transparansi, manajemen data, CMS).

**Pointer ke aplikasi (untuk narasi)**

- Sistem yang dikembangkan memisahkan **layanan publik** (tanpa login) dan **panel pengelola** (login), selaras dengan kebutuhan transparansi sekaligus pengamanan data.

---


### 3.3 Metode Pengumpulan Data

Bagi setiap metode, jelaskan **tujuan**, **prosedur**, dan **instrumen** (pedoman wawancara, daftar periksa observasi, kuesioner SUS).

#### 3.3.1 Wawancara (analisis kebutuhan dan masalah)

**Isi yang disarankan**

- **Jenis**: wawancara semi-terstruktur agar topik tetap pada kebutuhan sistem namun memungkinkan elaborasi.
- **Topik inti yang dihubungkan dengan modul aplikasi**:
  1. **Laporan ODGJ online**: alur laporan warga, validasi data, notifikasi ke petugas, tindak lanjut (diterima/ditolak/respon di dashboard).
  2. **Donasi online QRIS**: kebutuhan nominal, program donasi, konfirmasi pembayaran, callback/notifikasi pembayaran.
  3. **Transparansi donasi**: kebutuhan publikasi penerimaan dan pengeluaran, ekspor/PDF untuk akuntabilitas.
  4. **Manajemen data operasional**: pasien, jadwal rehabilitasi/pasien, jadwal petugas, stok/obat, riwayat pemeriksaan, aktivitas pasien (termasuk konten galeri publik bila dipakai).
  5. **CMS & konten publik**: profil yayasan, visi–misi, struktur organisasi, konten layanan (proses laporan ODGJ & tahapan rehabilitasi), pengaturan tampilan web (warna, latar, dll.).
  6. **Keamanan & akses**: pemisahan domain publik vs admin, peran pengguna (*role*), data yang boleh ditampilkan ke publik (mis. daftar pasien publik terbatas).
- **Teknik dokumentasi hasil**: transkrip ringkas, matriks kebutuhan, atau *use case* awal yang menjadi dasar *product backlog* Scrum.

#### 3.3.2 Studi dokumentasi

**Isi yang disarankan**

- Dokumen organisasi: SOP terkait donasi, pelaporan, dan rehabilitasi (jika ada).
- Dokumentasi teknis pengembangan: *repository* kode, diagram, konfigurasi integrasi pembayaran (tanpa menyertakan kredensial rahasia di naskah skripsi).

#### 3.3.3 Observasi (opsional)

**Isi yang disarankan**

- Observasi langsung terhadap alur kerja saat ini (manual/spreadsheet/media sosial) untuk memperkuat temuan wawancara.

#### 3.3.4 Kuesioner System Usability Scale (SUS)

**Isi yang disarankan**

- **Tujuan**: mengukur **kegunaan** antarmuka sistem setelah implementasi (skala standar 10 pernyataan, skor 0–100).
- **Kriteria interpretasi**: skala adopsi umum Bangor (*adjective rating*)—mis. skor di atas 68 dianggap di atas rata-rata (sesuaikan dengan literatur yang Anda kutip).
- **Responden**: minimal jumlah sesuai aturan kampus; pastikan responden pernah menggunakan fitur yang dinilai (dashboard admin dan/atau halaman publik).
- **Etika**: persetujuan partisipasi, anonimisasi identitas di laporan.

---

### 3.4 Metode Pengembangan Perangkat Lunak: Scrum

**Isi yang disarankan**

- **Landasan singkat**: Scrum adalah kerangka kerja Agile berbasis *sprint*; tekankan iterasi, transparansi, inspeksi, dan adaptasi melalui acara Scrum.
- **Peran**: *Product Owner* (prioritas dari yayasan), *Scrum Master* (fasilitasi proses—sering peneliti), *Development Team* (implementasi—peneliti/tim kecil). Sesuaikan dengan realitas skripsi (mis. satu developer) secara jujur dalam narasi.
- **Artefak**: *product backlog*, *sprint backlog*, *increment* (versi yang dapat didemokan).
- **Acara**: *sprint planning*, *daily scrum* (sinkron singkat), *sprint review* dengan pemangku kepentingan, *sprint retrospective*.
- **Durasi sprint**: mis. dua minggu (tetap konsisten di seluruh Bab III).
- **Pemetaan ke fitur sistem** (contoh urutan backlog yang selaras dengan judul skripsi):
  1. Infrastruktur dasar: autentikasi admin, pemisahan domain, kerangka halaman publik.
  2. **CMS & konten**: profil, visi–misi, struktur, layanan, pengaturan web.
  3. **Laporan ODGJ**: form publik, penyimpanan lampiran, notifikasi email, modul verifikasi/respon di dashboard.
  4. **Donasi QRIS**: form donasi, integrasi gateway, halaman pembayaran, callback/status.
  5. **Transparansi donasi**: agregasi data, halaman publik, unduhan PDF.
  6. **Manajemen data**: pasien, jadwal, stok, petugas, aktivitas—sesuai prioritas operasional yayasan.
- **Alat kolaborasi** (opsional): papan tugas, versi kode, catatan rapat sprint.

---

### 3.5 Tahapan Penelitian / Alur Kerja

Struktur ini bisa berupa subbab atau satu diagram alur (mis. *figure* alur penelitian R&D).

#### 3.5.1 Analisis kebutuhan dan masalah

- Ringkasan hasil wawancara dan dokumentasi.
- Definisi masalah operasional vs solusi sistem (gap analysis singkat).

#### 3.5.2 Perancangan sistem

- **Perancangan arsitektur**: client–server, pemisahan domain publik–admin, integrasi layanan pihak ketiga (pembayaran, email).
- **Perancangan basis data** (konseptual/logis): entitas utama—mis. laporan ODGJ, donasi, pengeluaran donasi, pasien, jadwal, stok, pengguna, konten CMS.
- **Perancangan antarmuka**: wireframe/mockup halaman kunci (beranda, form laporan, donasi & QRIS, transparansi, dashboard).
- **Perancangan keamanan**: autentikasi, otorisasi peran, perlindungan data sensitif, penanganan webhook/callback.

#### 3.5.3 Implementasi

- **Lingkungan pengembangan**: PHP, Laravel, basis data, *front-end* (Blade, Tailwind/Vite, dll.—sesuai proyek).
- **Modul implementasi** yang dijelaskan di Bab IV (selaraskan penomoran):
  1. Modul publik & CMS.
  2. Modul laporan ODGJ online.
  3. Modul donasi QRIS & callback.
  4. Modul transparansi donasi.
  5. Modul manajemen data operasional & dashboard.

#### 3.5.4 Pengujian dan evaluasi

- **Pengujian fungsional** (*black box*): skenario sesuai user story (submit laporan, pembayaran, persetujuan laporan, input data, pembaruan konten).
- **Pengujian integrasi**: notifikasi email, callback pembayaran (lingkungan sandbox/production—jelaskan batasan).
- **Evaluasi kegunaan**: administrasi kuesioner **SUS**, perhitungan skor, interpretasi, saran perbaikan UI/UX.

---

---

*File ini hanya berisi **struktur dan panduan isi**; narasi lengkap, kutipan, dan angka hasil pengisian kuesioner ditulis di dokumen skripsi utama.*
