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
        Schema::create('odgj_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kategori', 50); // penjemputan | pengantaran
            $table->string('lokasi')->nullable();
            $table->decimal('lokasi_lat', 10, 8)->nullable();
            $table->decimal('lokasi_lng', 11, 8)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('kontak', 50)->nullable();
            $table->string('status', 30)->default('baru'); // baru, diproses, selesai
            $table->string('nomor_laporan', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odgj_reports');
    }
};
