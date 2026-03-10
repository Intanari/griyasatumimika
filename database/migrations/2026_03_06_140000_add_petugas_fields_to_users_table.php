<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->string('foto')->nullable()->after('remember_token');
            $table->string('jenis_kelamin', 1)->nullable()->after('foto');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->date('tanggal_bergabung')->nullable()->after('alamat');
            $table->string('status_kerja', 20)->default('aktif')->after('tanggal_bergabung'); // aktif, cuti, nonaktif
            $table->string('shift_jaga', 20)->nullable()->after('status_kerja'); // pagi, siang, malam
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique('users_username_unique');
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['username', 'foto', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'tanggal_bergabung', 'status_kerja', 'shift_jaga'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
