<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $shifts = [
            ['nama' => 'Pagi', 'jam_mulai' => '07:00', 'jam_selesai' => '14:00'],
            ['nama' => 'Siang', 'jam_mulai' => '14:00', 'jam_selesai' => '21:00'],
            ['nama' => 'Malam', 'jam_mulai' => '21:00', 'jam_selesai' => '07:00'],
        ];

        foreach ($shifts as $shift) {
            Shift::updateOrCreate(
                ['nama' => $shift['nama']],
                ['jam_mulai' => $shift['jam_mulai'], 'jam_selesai' => $shift['jam_selesai']]
            );
        }
    }
}
