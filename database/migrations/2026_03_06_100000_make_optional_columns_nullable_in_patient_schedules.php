<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'jenis_kegiatan')) {
                $table->string('jenis_kegiatan')->nullable()->change();
            }
            if (Schema::hasColumn('patient_schedules', 'pembimbing')) {
                $table->string('pembimbing')->nullable()->change();
            }
            if (Schema::hasColumn('patient_schedules', 'lokasi')) {
                $table->string('lokasi')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'jenis_kegiatan')) {
                $table->string('jenis_kegiatan')->nullable(false)->change();
            }
            if (Schema::hasColumn('patient_schedules', 'pembimbing')) {
                $table->string('pembimbing')->nullable(false)->change();
            }
            if (Schema::hasColumn('patient_schedules', 'lokasi')) {
                $table->string('lokasi')->nullable(false)->change();
            }
        });
    }
};
