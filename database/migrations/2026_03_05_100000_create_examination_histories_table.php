<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examination_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->date('tanggal_pemeriksaan');
            $table->string('tempat_pemeriksaan');
            $table->text('keluhan')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('tindakan_obat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examination_histories');
    }
};
