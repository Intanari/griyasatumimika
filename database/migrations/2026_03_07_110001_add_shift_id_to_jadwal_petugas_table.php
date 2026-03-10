<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->foreignUuid('shift_id')->nullable()->after('user_id')->constrained('shifts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
        });
    }
};
