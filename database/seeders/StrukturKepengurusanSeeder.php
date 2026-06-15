<?php

namespace Database\Seeders;

use App\Models\StrukturKepengurusan;
use Illuminate\Database\Seeder;

class StrukturKepengurusanSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'pembina' => ['nama' => 'BIASIUS NARWADAN, S.H', 'status' => 'Pembina', 'keterangan' => 'Pembina Yayasan Griya Satu Mimika yang menuntun arah dan kebijakan strategis yayasan.'],
            'ketua_yayasan' => ['nama' => 'YOSEVITALIANA ACHMAD, S.I.KOM', 'status' => 'Ketua Yayasan', 'keterangan' => 'Memimpin pengelolaan yayasan dan memastikan seluruh program berjalan sesuai visi misi.'],
            'ketua_pengawas' => ['nama' => 'D. NUSSY, S.SOS', 'status' => 'Ketua Pengawas', 'keterangan' => 'Mengawasi pelaksanaan program dan tata kelola yayasan agar tetap transparan dan akuntabel.'],
            'sekretaris' => ['nama' => 'AGUNG HENDY. T', 'status' => 'Sekretaris', 'keterangan' => 'Menangani administrasi, surat-menyurat, serta dokumentasi resmi kegiatan yayasan.'],
            'bendahara' => ['nama' => 'YUNTI ANCELINA FATUBUN', 'status' => 'Bendahara', 'keterangan' => 'Mengelola keuangan dan laporan penggunaan dana yayasan secara tertib dan transparan.'],
            'pengawas' => ['nama' => 'ANNA MARGARETHA', 'status' => 'Pengawas', 'keterangan' => 'Mendukung fungsi pengawasan agar seluruh kegiatan berjalan sesuai ketentuan dan nilai yayasan.'],
        ];

        foreach ($roles as $role => $data) {
            StrukturKepengurusan::updateOrCreate(
                ['role' => $role],
                ['nama' => $data['nama'], 'status' => $data['status'], 'keterangan' => $data['keterangan']]
            );
        }
    }
}
