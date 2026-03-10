<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\DonationExpense;
use App\Models\ExaminationHistory;
use App\Models\InventoryItem;
use App\Models\JadwalLibur;
use App\Models\JadwalPetugas;
use App\Models\OdgjReport;
use App\Models\Patient;
use App\Models\PatientActivity;
use App\Models\PatientSchedule;
use App\Models\RehabilitationSchedule;
use App\Models\Shift;
use App\Models\StockExpense;
use App\Models\StockSupply;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding dummy data...');

        // 1. Users (petugas & manajer) - skip if already have more than superadmin
        $petugasUsers = $this->seedUsers();
        $this->command->info('Users (petugas/manajer) seeded.');

        // 2. Patients
        $patients = $this->seedPatients();
        $this->command->info('Patients seeded.');

        // 3. Donations
        $this->seedDonations();
        $this->command->info('Donations seeded.');

        // 4. ODGJ Reports
        $this->seedOdgjReports();
        $this->command->info('ODGJ Reports seeded.');

        // 5. Patient Schedules
        $this->seedPatientSchedules($patients, $petugasUsers);
        $this->command->info('Patient schedules seeded.');

        // 6. Examination Histories
        $this->seedExaminationHistories($patients);
        $this->command->info('Examination histories seeded.');

        // 7. Jadwal Petugas
        $this->seedJadwalPetugas($petugasUsers);
        $this->command->info('Jadwal petugas seeded.');

        // 8. Jadwal Libur
        $this->seedJadwalLibur($petugasUsers);
        $this->command->info('Jadwal libur seeded.');

        // 9. Patient Activities
        $this->seedPatientActivities($patients);
        $this->command->info('Patient activities seeded.');

        // 10. Rehabilitation Schedules
        $this->seedRehabilitationSchedules($petugasUsers);
        $this->command->info('Rehabilitation schedules seeded.');

        // 11. Inventory Items
        $inventoryItems = $this->seedInventoryItems();
        $this->command->info('Inventory items seeded.');

        // 12. Stock Transactions
        $this->seedStockTransactions($inventoryItems, $petugasUsers);
        $this->command->info('Stock transactions seeded.');

        // 13. Donation Expenses
        $this->seedDonationExpenses();
        $this->command->info('Donation expenses seeded.');

        // 14. Stock Supplies & Expenses
        $this->seedStockSuppliesAndExpenses();
        $this->command->info('Stock supplies & expenses seeded.');

        $this->command->info('Dummy data seeding completed.');
    }

    private function seedUsers(): array
    {
        $users = [];
        $roles = [
            ['role' => User::ROLE_MANAGER, 'name' => 'Budi Manajer', 'username' => 'manajer1'],
            ['role' => User::ROLE_PETUGAS, 'name' => 'Siti Petugas', 'username' => 'petugas1'],
            ['role' => User::ROLE_PETUGAS, 'name' => 'Ahmad Petugas', 'username' => 'petugas2'],
        ];
        foreach ($roles as $i => $r) {
            $users[] = User::updateOrCreate(
                ['email' => $r['username'] . '@yayasan.dev'],
                [
                    'name' => $r['name'],
                    'username' => $r['username'],
                    'password' => 'password',
                    'role' => $r['role'],
                    'is_active' => true,
                    'status_kerja' => User::STATUS_AKTIF,
                    'shift_jaga' => [User::SHIFT_PAGI, User::SHIFT_SIANG, User::SHIFT_MALAM][$i % 3],
                    'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => now()->subYears(30),
                    'alamat' => 'Jl. Contoh No.' . ($i + 1),
                    'no_hp' => '0812345678' . $i,
                    'tanggal_bergabung' => now()->subMonths(6),
                ]
            );
        }
        return $users;
    }

    private function seedPatients(): array
    {
        $patients = [];
        $names = ['Andi Wijaya', 'Bunga Kusuma', 'Cahyo Pratama', 'Dewi Lestari', 'Eko Saputra'];
        foreach ($names as $i => $name) {
            $patients[] = Patient::create([
                'kode_pasien' => 'P-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'nama_lengkap' => $name,
                'tempat_lahir' => ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang'][$i],
                'tanggal_lahir' => now()->subYears(25 + $i * 5),
                'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',
                'tanggal_masuk' => now()->subMonths(3 + $i),
                'status' => $i === 4 ? 'selesai' : 'aktif',
            ]);
        }
        return $patients;
    }

    private function seedDonations(): void
    {
        $programs = ['Rehabilitasi ODGJ', 'Bantuan Pendidikan', 'Operasional Yayasan'];
        for ($i = 0; $i < 8; $i++) {
            Donation::create([
                'program' => $programs[$i % 3],
                'donor_name' => 'Donatur ' . ($i + 1),
                'donor_email' => 'donatur' . ($i + 1) . '@example.com',
                'donor_phone' => '0812' . str_pad((string) $i, 8, '0'),
                'amount' => [500000, 1000000, 2500000, 5000000][$i % 4],
                'message' => $i % 2 === 0 ? 'Semoga bermanfaat.' : null,
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'transaction_id' => $i >= 4 ? 'TRX-' . Str::random(8) : null,
                'status' => ['pending', 'paid', 'paid', 'paid', 'failed', 'expired'][$i % 6],
                'paid_at' => $i >= 2 && $i <= 4 ? now()->subDays($i) : null,
            ]);
        }
    }

    private function seedOdgjReports(): void
    {
        $kategoris = ['penjemputan', 'pengantaran'];
        for ($i = 0; $i < 5; $i++) {
            OdgjReport::create([
                'kategori' => $kategoris[$i % 2],
                'lokasi' => 'Jl. Lokasi Laporan No.' . ($i + 1),
                'lokasi_lat' => -6.2 + ($i * 0.01),
                'lokasi_lng' => 106.8 + ($i * 0.01),
                'deskripsi' => 'Deskripsi laporan dummy ' . ($i + 1),
                'kontak' => '0812345678' . $i,
                'email' => 'pelapor' . ($i + 1) . '@example.com',
                'status' => ['baru', 'diproses', 'selesai'][$i % 3],
                'nomor_laporan' => 'LAP-' . now()->format('Ymd') . '-' . str_pad((string) ($i + 1), 3, '0'),
            ]);
        }
    }

    private function seedPatientSchedules(array $patients, array $users): void
    {
        $jenis = ['kontrol', 'terapi', 'konseling'];
        foreach ($patients as $i => $patient) {
            for ($j = 0; $j < 3; $j++) {
                $tanggal = now()->addDays($j * 2);
                PatientSchedule::create([
                    'patient_id' => $patient->id,
                    'pembimbing_id' => $users[$i % count($users)]->id ?? null,
                    'tanggal' => $tanggal,
                    'jam_mulai' => '08:00',
                    'jam_selesai' => '10:00',
                    'tempat' => 'Ruang Terapi ' . ($j + 1),
                    'jenis' => $jenis[$j % 3],
                    'status' => ['terjadwal', 'selesai', 'dibatalkan'][$j % 3],
                    'catatan' => $j === 1 ? 'Catatan jadwal dummy.' : null,
                    'reminder_before_minutes' => 30,
                ]);
            }
        }
    }

    private function seedExaminationHistories(array $patients): void
    {
        foreach ($patients as $i => $patient) {
            for ($j = 0; $j < 2; $j++) {
                ExaminationHistory::create([
                    'patient_id' => $patient->id,
                    'tanggal_pemeriksaan' => now()->subDays(10 + $i * 5 + $j * 3),
                    'tempat_pemeriksaan' => 'Klinik Yayasan',
                    'keluhan' => 'Kontrol rutin.',
                    'hasil_pemeriksaan' => 'Kondisi stabil.',
                    'tindakan_obat' => 'Terapi lanjutan.',
                ]);
            }
        }
    }

    private function seedJadwalPetugas(array $users): void
    {
        $shifts = Shift::all();
        if ($shifts->isEmpty()) {
            return;
        }
        foreach ($users as $user) {
            for ($d = 0; $d < 5; $d++) {
                $tanggal = now()->addDays($d);
                $shift = $shifts->random();
                JadwalPetugas::create([
                    'user_id' => $user->id,
                    'shift_id' => $shift->id,
                    'tipe' => $d % 3 === 0 ? JadwalPetugas::TIPE_GANTI : JadwalPetugas::TIPE_RUTIN,
                    'tanggal' => $tanggal,
                    'shift' => strtolower($shift->nama),
                    'jam_mulai' => $shift->jam_mulai,
                    'jam_selesai' => $shift->jam_selesai,
                    'lokasi' => 'Gedung Utama',
                    'keterangan' => 'Jaga rutin.',
                ]);
            }
        }
    }

    private function seedJadwalLibur(array $users): void
    {
        foreach ($users as $i => $user) {
            if ($i === 0) {
                JadwalLibur::create([
                    'user_id' => $user->id,
                    'tanggal' => now()->addDays(7),
                    'keterangan' => 'Cuti tahunan',
                ]);
            }
        }
    }

    private function seedPatientActivities(array $patients): void
    {
        $jenis = ['terapi', 'senam', 'keterampilan', 'ibadah', 'rekreasi', 'lainnya'];
        foreach ($patients as $i => $patient) {
            for ($j = 0; $j < 4; $j++) {
                PatientActivity::create([
                    'patient_id' => $patient->id,
                    'tanggal' => now()->subDays($j * 2),
                    'jenis_aktivitas' => $jenis[$j % count($jenis)],
                    'deskripsi' => 'Kegiatan dummy ' . ($j + 1),
                    'hasil_evaluasi' => $j % 2 === 0 ? 'Baik' : null,
                    'waktu_mulai' => '09:00',
                    'waktu_selesai' => '10:30',
                    'durasi_menit' => 90,
                    'tempat' => 'Ruang Aktivitas',
                    'batch_uuid' => Str::uuid()->toString(),
                ]);
            }
        }
    }

    private function seedRehabilitationSchedules(array $users): void
    {
        $kegiatan = [
            ['nama' => 'Senam Pagi', 'hari' => 'senin'],
            ['nama' => 'Terapi Kelompok', 'hari' => 'rabu'],
            ['nama' => 'Keterampilan', 'hari' => 'jumat'],
        ];
        foreach ($kegiatan as $i => $k) {
            RehabilitationSchedule::create([
                'nama_kegiatan' => $k['nama'],
                'hari' => $k['hari'],
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:30',
                'tempat' => 'Aula',
                'pembimbing_id' => $users[$i % count($users)]->id ?? null,
                'deskripsi' => 'Jadwal rehabilitasi mingguan.',
                'is_aktif' => true,
            ]);
        }
    }

    private function seedInventoryItems(): array
    {
        $items = [
            ['name' => 'Beras', 'category' => 'makanan', 'unit' => 'kg'],
            ['name' => 'Paracetamol', 'category' => 'obat', 'unit' => 'strip'],
            ['name' => 'Tensimeter', 'category' => 'alat_kesehatan', 'unit' => 'pcs'],
            ['name' => 'Sabun Mandi', 'category' => 'kebersihan', 'unit' => 'pcs'],
            ['name' => 'Alat Tulis', 'category' => 'perlengkapan', 'unit' => 'pcs'],
        ];
        $created = [];
        foreach ($items as $item) {
            $created[] = InventoryItem::create([
                'name' => $item['name'],
                'category' => $item['category'],
                'quantity' => rand(20, 100),
                'unit' => $item['unit'],
                'min_stock' => 5,
                'date_in' => now()->subDays(30),
                'expiry_date' => in_array($item['category'], ['obat', 'makanan']) ? now()->addMonths(6) : null,
                'supplier' => 'Supplier Dummy',
                'unit_price' => rand(5000, 100000),
                'notes' => 'Stok dummy.',
            ]);
        }
        return $created;
    }

    private function seedStockTransactions(array $inventoryItems, array $users): void
    {
        foreach ($inventoryItems as $i => $item) {
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => 'in',
                'quantity' => 50,
                'staff_name' => 'Admin',
                'user_id' => $users[0]->id ?? null,
                'notes' => 'Stok awal.',
            ]);
            if ($i % 2 === 0) {
                StockTransaction::create([
                    'inventory_item_id' => $item->id,
                    'type' => 'out',
                    'quantity' => 10,
                    'staff_name' => 'Petugas',
                    'user_id' => $users[1]->id ?? null,
                    'notes' => 'Penggunaan rutin.',
                ]);
            }
        }
    }

    private function seedDonationExpenses(): void
    {
        $keterangan = ['Operasional harian', 'Obat-obatan', 'Makanan pasien', 'Perawatan fasilitas'];
        foreach ($keterangan as $i => $k) {
            DonationExpense::create([
                'keterangan' => $k,
                'jumlah' => [500000, 1500000, 800000, 300000][$i],
                'tanggal_pengeluaran' => now()->subDays($i * 2),
            ]);
        }
    }

    private function seedStockSuppliesAndExpenses(): void
    {
        for ($i = 0; $i < 4; $i++) {
            StockSupply::create([
                'nama' => 'Stok Masuk ' . ($i + 1),
                'jumlah' => rand(10, 50),
                'harga' => rand(10000, 500000),
            ]);
            StockExpense::create([
                'nama' => 'Stok Keluar ' . ($i + 1),
                'jumlah' => rand(5, 20),
            ]);
        }
    }
}
