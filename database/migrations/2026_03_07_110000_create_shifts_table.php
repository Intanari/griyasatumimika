<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 100);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        DB::table('shifts')->insert([
            ['id' => (string) Str::uuid(), 'nama' => 'Pagi', 'jam_mulai' => '07:00', 'jam_selesai' => '14:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) Str::uuid(), 'nama' => 'Siang', 'jam_mulai' => '14:00', 'jam_selesai' => '21:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) Str::uuid(), 'nama' => 'Malam', 'jam_mulai' => '21:00', 'jam_selesai' => '07:00', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
