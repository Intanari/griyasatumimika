# Sprint Retrospective (Evaluasi Akhir Sprint)

## Sprint 9
**Tanggal acuan:** 2026-03-15  
**Branch/Komit:** `origin/v23` (`b3112d4`)  
**Referensi:** `sprint planning.md`, `daily scrum.md`, `increment-development.md`, `sprint review.md`

## Ringkasan Sprint
Sprint 9 berfokus pada penyelesaian situs publik yayasan yang mencakup CMS konten publik, web settings, halaman informasi publik, transparansi donasi, dan ekspor PDF. Berdasarkan hasil review, target utama sprint tercapai dan increment dapat digunakan untuk evaluasi lanjutan.

## Apa yang Berjalan Baik
- Perencanaan sprint selaras dengan implementasi, sehingga cakupan kerja tetap fokus pada target `PB-013` s.d. `PB-024` serta `PB-040` s.d. `PB-042`.
- Implementasi bertahap dari konten publik ke transparansi donasi membantu menjaga alur pengembangan tetap terstruktur.
- Refactor view publik di akhir sprint membantu merapikan konsistensi tampilan antar halaman.
- Dokumentasi artefak sprint (daily scrum, increment/development, sprint review) sudah tersedia dan saling terkait.

## Apa yang Kurang Optimal
- Beberapa bagian evaluasi hasil uji masih berupa ringkasan dokumen, belum seluruhnya disertai bukti formal (mis. daftar kasus uji per halaman).
- Umpan balik Product Owner/penguji belum terdokumentasi rinci pada sprint ini.
- Validasi edge case konten dinamis (data kosong/parsial) masih perlu diperluas agar semua variasi halaman publik benar-benar konsisten.

## Akar Masalah (Root Cause)
- Fokus sprint lebih besar pada penyelesaian fitur inti sehingga dokumentasi bukti uji detail belum diprioritaskan dari awal.
- Proses review lebih menekankan keberfungsian umum, belum sepenuhnya memakai template check-per-acceptance-criteria dengan evidensi terpisah.
- Belum ada checklist khusus untuk pengumpulan feedback formal dari stakeholder di akhir sprint.

## Rencana Perbaikan Sprint Berikutnya
1. Menyiapkan template uji per acceptance criteria sejak awal sprint (per PB), termasuk kolom status, catatan bug, dan bukti hasil.
2. Menambahkan checklist khusus fallback UI untuk setiap halaman publik agar kasus konten kosong/parsial tervalidasi sistematis.
3. Menjadwalkan sesi review singkat terstruktur untuk menangkap umpan balik Product Owner/penguji dalam format yang terdokumentasi.
4. Melakukan regresi ringan lintas modul publik setelah setiap perubahan besar pada view atau web settings.

## Komitmen Tindakan (Action Items)
- Membuat daftar test case ringkas untuk modul publik (CMS, layanan, galeri, transparansi, ekspor PDF).
- Menyusun format catatan bug dan perbaikan per PB agar mudah ditelusuri.
- Melengkapi bukti verifikasi (screenshot/hasil PDF/tautan halaman) di dokumen sprint review.
- Menetapkan standar "selesai" dokumen sprint: target, hasil, bukti uji, temuan, perbaikan, dan keputusan akhir.

## Kesimpulan Retrospektif
Sprint 9 dinilai berhasil dari sisi penyelesaian fitur inti dan kesesuaian dengan backlog prioritas. Proses pengembangan berjalan mengikuti alur Scrum yang terdokumentasi: `sprint planning.md` digunakan sebagai pedoman pemilihan pekerjaan, `daily scrum.md` dipakai untuk memantau progres harian secara terarah, `increment-development.md` menjadi bukti increment hasil implementasi, serta `sprint review.md` menyatukan ringkasan pencapaian dan hasil verifikasi. Tahap `sprint retrospective.md` kemudian merumuskan perbaikan proses agar kualitas evaluasi dan dokumentasi menjadi lebih kuat pada sprint berikutnya.

