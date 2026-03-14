<?php

namespace Database\Seeders;

use App\Models\ProsesLaporanOdgj;
use App\Models\TahapanRehabilitasi;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        if (ProsesLaporanOdgj::exists()) {
            return;
        }

        $proses = [
            ['no_urut' => 1, 'judul' => 'Isi Form Laporan', 'keterangan' => 'Lengkapi data pelapor, lokasi ODGJ, deskripsi singkat, dan pilih kategori: Penjemputan atau Pengantaran ke RSJ.'],
            ['no_urut' => 2, 'judul' => 'Verifikasi Tim', 'keterangan' => 'Tim kami melakukan klarifikasi via telepon atau pesan untuk memastikan data akurat dan kebutuhan mendesak.'],
            ['no_urut' => 3, 'judul' => 'Respon Cepat', 'keterangan' => 'Laporan diterima atau ditolak dengan alasan jelas. Email konfirmasi otomatis dikirim ke pelapor.'],
            ['no_urut' => 4, 'judul' => 'Penindaklanjutan', 'keterangan' => 'Jika diterima: penjemputan atau pengantaran ke fasilitas kesehatan jiwa, lalu mengikuti alur rehabilitasi.'],
        ];
        foreach ($proses as $p) {
            ProsesLaporanOdgj::create($p);
        }

        if (TahapanRehabilitasi::exists()) {
            return;
        }

        $tahapan = [
            ['no_urut' => 1, 'status' => 'Penjangkauan', 'judul' => 'Tanggap Laporan dan Survei Lapangan', 'keterangan' => 'Tim menerima laporan dari warga, keluarga, atau mitra, melakukan klarifikasi dan kunjungan awal untuk memastikan keamanan serta memetakan kebutuhan mendesak penerima manfaat.'],
            ['no_urut' => 2, 'status' => 'Asesmen Awal', 'judul' => 'Penilaian Kondisi Klinis dan Sosial', 'keterangan' => 'Tenaga profesional melakukan asesmen singkat mengenai kesehatan jiwa, status fisik, dukungan keluarga, dan risiko. Hasil asesmen menjadi dasar rencana penanganan awal.'],
            ['no_urut' => 3, 'status' => 'Rujukan & Perawatan', 'judul' => 'Fasilitasi Akses ke Fasilitas Kesehatan Jiwa', 'keterangan' => 'Penerima manfaat dirujuk ke RSJ atau layanan kesehatan terdekat bila perlu. Tim membantu administrasi, koordinasi dengan tenaga medis, dan memastikan keluarga memahami rencana terapi.'],
            ['no_urut' => 4, 'status' => 'Pendampingan Rehabilitasi', 'judul' => 'Pemantauan Terapi dan Dukungan Keluarga', 'keterangan' => 'Selama rehabilitasi, tim melakukan pemantauan berkala, memastikan terapi sesuai rencana, serta memberikan edukasi kepada keluarga tentang perawatan dan dukungan di rumah.'],
            ['no_urut' => 5, 'status' => 'Pelatihan Kemandirian', 'judul' => 'Penguatan Keterampilan dan Rutinitas Harian', 'keterangan' => 'Setelah kondisi stabil, penerima manfaat ikut pelatihan keterampilan dasar kerja, pengelolaan diri, dan aktivitas produktif untuk bekal hidup mandiri.'],
            ['no_urut' => 6, 'status' => 'Reintegrasi Sosial', 'judul' => 'Kembali ke Keluarga dan Komunitas', 'keterangan' => 'Tahap akhir berfokus pada penerimaan kembali di lingkungan. Tim membantu mediasi dengan keluarga dan tetangga, menyusun rencana tindak lanjut agar penerima manfaat tetap dipantau dan tidak kembali terlantar.'],
        ];
        foreach ($tahapan as $t) {
            TahapanRehabilitasi::create($t);
        }
    }
}
