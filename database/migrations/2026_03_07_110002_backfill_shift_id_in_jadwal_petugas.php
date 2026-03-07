<?php

use App\Models\JadwalPetugas;
use App\Models\Shift;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $pagi = Shift::where('nama', 'Pagi')->first();
        $siang = Shift::where('nama', 'Siang')->first();
        $malam = Shift::where('nama', 'Malam')->first();

        if ($pagi) {
            JadwalPetugas::where('shift', 'pagi')->whereNull('shift_id')->update(['shift_id' => $pagi->id]);
        }
        if ($siang) {
            JadwalPetugas::where('shift', 'siang')->whereNull('shift_id')->update(['shift_id' => $siang->id]);
        }
        if ($malam) {
            JadwalPetugas::where('shift', 'malam')->whereNull('shift_id')->update(['shift_id' => $malam->id]);
        }
    }

    public function down(): void
    {
        JadwalPetugas::query()->update(['shift_id' => null]);
    }
};
