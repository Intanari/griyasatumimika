<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_schedules', 'start_reminder_sent_at')) {
                $table->timestamp('start_reminder_sent_at')
                    ->nullable()
                    ->after('reminder_sent_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'start_reminder_sent_at')) {
                $table->dropColumn('start_reminder_sent_at');
            }
        });
    }
};

