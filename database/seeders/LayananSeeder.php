<?php

namespace Database\Seeders;

use App\Models\ProsesLaporanOdgj;
use App\Models\TahapanRehabilitasi;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $proses = [
            ['no_urut' => 1, 'judul' => 'Pengisian Form Laporan', 'keterangan' => 'Pelapor mengisi data lengkap meliputi identitas pelapor, lokasi ODGJ, kondisi terkini, serta memilih jenis layanan: penjemputan atau pengantaran ke fasilitas kesehatan jiwa.'],
            ['no_urut' => 2, 'judul' => 'Verifikasi oleh Tim', 'keterangan' => 'Tim yayasan menghubungi pelapor untuk memastikan keakuratan data, menilai tingkat urgensi, dan menentukan langkah penanganan awal yang paling tepat.'],
            ['no_urut' => 3, 'judul' => 'Konfirmasi Status Laporan', 'keterangan' => 'Laporan diterima atau ditolak dengan alasan yang jelas. Notifikasi otomatis dikirim ke pelapor melalui email agar proses tetap transparan.'],
            ['no_urut' => 4, 'judul' => 'Penindaklanjutan Lapangan', 'keterangan' => 'Jika laporan diterima, tim melakukan penjemputan atau pengantaran ke fasilitas kesehatan jiwa, lalu penerima manfaat masuk ke alur rehabilitasi yayasan.'],
        ];

        foreach ($proses as $item) {
            ProsesLaporanOdgj::updateOrCreate(
                ['no_urut' => $item['no_urut']],
                ['judul' => $item['judul'], 'keterangan' => $item['keterangan']]
            );
        }
        ProsesLaporanOdgj::whereNotIn('no_urut', array_column($proses, 'no_urut'))->delete();

        $tahapan = [
            ['no_urut' => 1, 'status' => 'Penjangkauan', 'judul' => 'Tanggap Laporan dan Survei Lapangan', 'keterangan' => 'Tim menerima laporan dari warga, keluarga, atau mitra, melakukan klarifikasi dan kunjungan awal untuk memastikan keamanan serta memetakan kebutuhan mendesak penerima manfaat.'],
            ['no_urut' => 2, 'status' => 'Asesmen Awal', 'judul' => 'Penilaian Kondisi Klinis dan Sosial', 'keterangan' => 'Tenaga profesional melakukan asesmen singkat mengenai kesehatan jiwa, status fisik, dukungan keluarga, dan risiko. Hasil asesmen menjadi dasar rencana penanganan awal.'],
            ['no_urut' => 3, 'status' => 'Rujukan & Perawatan', 'judul' => 'Fasilitasi Akses ke Fasilitas Kesehatan Jiwa', 'keterangan' => 'Penerima manfaat dirujuk ke RSJ atau layanan kesehatan terdekat bila perlu. Tim membantu administrasi, koordinasi dengan tenaga medis, dan memastikan keluarga memahami rencana terapi.'],
            ['no_urut' => 4, 'status' => 'Pendampingan Rehabilitasi', 'judul' => 'Pemantauan Terapi dan Dukungan Keluarga', 'keterangan' => 'Selama rehabilitasi, tim melakukan pemantauan berkala, memastikan terapi sesuai rencana, serta memberikan edukasi kepada keluarga tentang perawatan dan dukungan di rumah.'],
            ['no_urut' => 5, 'status' => 'Pelatihan Kemandirian', 'judul' => 'Penguatan Keterampilan dan Rutinitas Harian', 'keterangan' => 'Setelah kondisi stabil, penerima manfaat mengikuti pelatihan keterampilan dasar kerja, pengelolaan diri, dan aktivitas produktif sebagai bekal hidup mandiri.'],
            ['no_urut' => 6, 'status' => 'Reintegrasi Sosial', 'judul' => 'Kembali ke Keluarga dan Komunitas', 'keterangan' => 'Tahap akhir berfokus pada penerimaan kembali di lingkungan. Tim membantu mediasi dengan keluarga dan tetangga, serta menyusun rencana tindak lanjut agar penerima manfaat tetap dipantau.'],
        ];

        foreach ($tahapan as $item) {
            TahapanRehabilitasi::updateOrCreate(
                ['no_urut' => $item['no_urut']],
                ['status' => $item['status'], 'judul' => $item['judul'], 'keterangan' => $item['keterangan']]
            );
        }
        TahapanRehabilitasi::whereNotIn('no_urut', array_column($tahapan, 'no_urut'))->delete();
    }
}
