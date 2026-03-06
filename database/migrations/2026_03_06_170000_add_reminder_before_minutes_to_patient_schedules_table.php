<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_schedules', 'reminder_before_minutes')) {
                $table->integer('reminder_before_minutes')
                    ->nullable()
                    ->after('pembimbing_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'reminder_before_minutes')) {
                $table->dropColumn('reminder_before_minutes');
            }
        });
    }
};

