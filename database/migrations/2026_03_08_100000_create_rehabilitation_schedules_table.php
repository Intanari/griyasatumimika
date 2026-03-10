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
        Schema::create('rehabilitation_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kegiatan');
            $table->string('hari'); // senin, selasa, rabu, kamis, jumat, sabtu, minggu
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->string('tempat')->nullable();
            $table->foreignUuid('pembimbing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rehabilitation_schedules');
    }
};
