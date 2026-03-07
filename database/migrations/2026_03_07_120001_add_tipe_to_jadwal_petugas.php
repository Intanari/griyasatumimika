<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->string('tipe', 20)->default('rutin')->after('shift_id'); // rutin, ganti
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};
