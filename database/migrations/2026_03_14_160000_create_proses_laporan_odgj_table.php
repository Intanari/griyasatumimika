<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proses_laporan_odgj', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no_urut')->default(1);
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proses_laporan_odgj');
    }
};
