<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan'); // donasi digunakan untuk apa
            $table->unsignedBigInteger('jumlah'); // berapa banyak (rupiah)
            $table->string('bukti_path')->nullable(); // bukti gambar
            $table->date('tanggal_pengeluaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_expenses');
    }
};
