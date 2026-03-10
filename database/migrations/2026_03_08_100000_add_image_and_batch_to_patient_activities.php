<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_activities', function (Blueprint $table) {
            $table->string('image')->nullable()->after('deskripsi');
            $table->string('batch_uuid')->nullable()->after('image')->index();
        });
    }

    public function down(): void
    {
        Schema::table('patient_activities', function (Blueprint $table) {
            if (Schema::hasColumn('patient_activities', 'batch_uuid')) {
                $table->dropIndex('patient_activities_batch_uuid_index');
            }
        });
        Schema::table('patient_activities', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('patient_activities', 'image')) {
                $columnsToDrop[] = 'image';
            }
            if (Schema::hasColumn('patient_activities', 'batch_uuid')) {
                $columnsToDrop[] = 'batch_uuid';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
