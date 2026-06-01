<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_supplies', function (Blueprint $table) {
            $table->string('satuan', 20)->default('pcs')->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('stock_supplies', function (Blueprint $table) {
            $table->dropColumn('satuan');
        });
    }
};
