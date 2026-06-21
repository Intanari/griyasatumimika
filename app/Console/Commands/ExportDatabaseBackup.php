<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDatabaseBackup extends Command
{
    protected $signature = 'db:export-backup';

    protected $description = 'Ekspor seluruh data aplikasi ke database/seeders/backup/ untuk dipulihkan via DatabaseBackupSeeder';

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

    public function handle(): int
    {
        $backupDir = database_path('seeders/backup');
        $dataDir = $backupDir.'/data';

        File::ensureDirectoryExists($dataDir);

        $summary = [];

        foreach (self::TABLES as $table) {
            $rows = DB::table($table)->orderBy('id')->get();
            $payload = $rows->map(fn ($row) => (array) $row)->values()->all();

            File::put(
                $dataDir.'/'.$table.'.json',
                json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
            );

            $count = count($payload);
            $summary[$table] = $count;
            $this->line(sprintf('  %s: %d baris', $table, $count));
        }

        File::put($backupDir.'/manifest.json', json_encode([
            'exported_at' => now()->toIso8601String(),
            'tables' => self::TABLES,
            'row_counts' => $summary,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");

        $total = array_sum($summary);
        $this->newLine();
        $this->info("Backup selesai: {$total} baris di ".count(self::TABLES).' tabel.');
        $this->info('Pulihkan di server baru: php artisan migrate && php artisan db:seed --class=DatabaseBackupSeeder');

        return self::SUCCESS;
    }
}
