<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama'); // nama stok barang
            $table->unsignedInteger('jumlah');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_expenses');
    }
};
