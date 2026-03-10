<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_schedules', 'pembimbing_id')) {
                $table->foreignUuid('pembimbing_id')
                    ->nullable()
                    ->after('patient_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('patient_schedules', 'reminder_sent_at')) {
                $table->timestamp('reminder_sent_at')
                    ->nullable()
                    ->after('pembimbing_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patient_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('patient_schedules', 'pembimbing_id')) {
                $table->dropConstrainedForeignId('pembimbing_id');
            }

            if (Schema::hasColumn('patient_schedules', 'reminder_sent_at')) {
                $table->dropColumn('reminder_sent_at');
            }
        });
    }
};

