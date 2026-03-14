<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_kepengurusan', function (Blueprint $table) {
            $table->id();
            $table->string('role', 64)->unique(); // pembina, ketua_yayasan, ketua_pengawas, sekretaris, bendahara, pengawas
            $table->string('foto')->nullable();
            $table->string('nama')->nullable();
            $table->string('status')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_kepengurusan');
    }
};
