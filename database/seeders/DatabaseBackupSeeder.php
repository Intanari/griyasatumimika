<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DatabaseBackupSeeder extends Seeder
{
    /** @var list<string> */
    private const TABLES = [
        'users',
        'shifts',
        'profil_yayasan',
        'visi_misi',
        'web_settings',
        'struktur_kepengurusan',
        'petugas_yayasan',
        'proses_laporan_odgj',
        'tahapan_rehabilitasi',
        'patients',
        'odgj_reports',
        'donations',
        'donation_expenses',
        'inventory_items',
        'stock_supplies',
        'stock_expenses',
        'stock_transactions',
        'examination_histories',
        'patient_activities',
        'patient_schedules',
        'rehabilitation_schedules',
        'jadwal_petugas',
        'jadwal_libur',
    ];

    public function run(): void
    {
        $dataDir = database_path('seeders/backup/data');
        $manifestPath = database_path('seeders/backup/manifest.json');

        if (! File::isDirectory($dataDir) || ! File::exists($manifestPath)) {
            $this->command?->error('Backup tidak ditemukan. Jalankan: php artisan db:export-backup');

            return;
        }

        $manifest = json_decode(File::get($manifestPath), true);
        $exportedAt = $manifest['exported_at'] ?? 'tidak diketahui';

        $this->command?->info("Memulihkan backup database (dieksport: {$exportedAt})...");

        Schema::disableForeignKeyConstraints();

        foreach (array_reverse(self::TABLES) as $table) {
            DB::table($table)->delete();
        }

        $total = 0;

        foreach (self::TABLES as $table) {
            $path = $dataDir.'/'.$table.'.json';

            if (! File::exists($path)) {
                $this->command?->warn("  Lewati {$table}: file backup tidak ada.");

                continue;
            }

            $rows = json_decode(File::get($path), true);

            if (! is_array($rows) || $rows === []) {
                $this->command?->line("  {$table}: 0 baris");

                continue;
            }

            foreach (array_chunk($rows, 100) as $chunk) {
                DB::table($table)->insert($chunk);
            }

            $count = count($rows);
            $total += $count;
            $this->command?->line("  {$table}: {$count} baris");
        }

        Schema::enableForeignKeyConstraints();

        $this->command?->info("Backup dipulihkan: {$total} baris.");
        $this->command?->warn('File upload (foto, bukti, dll.) tidak ikut backup — salin folder storage/app/public secara manual bila perlu.');
    }
}
