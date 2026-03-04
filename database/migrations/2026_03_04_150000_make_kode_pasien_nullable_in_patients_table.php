<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('kode_pasien', 30)->nullable()->change();
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->dropUnique(['kode_pasien']);
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('kode_pasien', 30)->nullable(false)->change();
            $table->unique('kode_pasien');
        });
    }
};
