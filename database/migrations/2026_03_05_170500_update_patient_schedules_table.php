<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_schedules', 'patient_id')) {
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('patient_schedules', 'tanggal')) {
                $table->date('tanggal')->index();
            }
            if (!Schema::hasColumn('patient_schedules', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable();
            }
            if (!Schema::hasColumn('patient_schedules', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable();
            }
            if (!Schema::hasColumn('patient_schedules', 'tempat')) {
                $table->string('tempat', 255)->nullable();
            }
            if (!Schema::hasColumn('patient_schedules', 'jenis')) {
                $table->string('jenis', 50)->default('kontrol');
            }
            if (!Schema::hasColumn('patient_schedules', 'status')) {
                $table->string('status', 30)->default('terjadwal');
            }
            if (!Schema::hasColumn('patient_schedules', 'catatan')) {
                $table->text('catatan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'patient_id')) {
                $table->dropConstrainedForeignId('patient_id');
            }
            if (Schema::hasColumn('patient_schedules', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            if (Schema::hasColumn('patient_schedules', 'jam_mulai')) {
                $table->dropColumn('jam_mulai');
            }
            if (Schema::hasColumn('patient_schedules', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
            if (Schema::hasColumn('patient_schedules', 'tempat')) {
                $table->dropColumn('tempat');
            }
            if (Schema::hasColumn('patient_schedules', 'jenis')) {
                $table->dropColumn('jenis');
            }
            if (Schema::hasColumn('patient_schedules', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('patient_schedules', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};

