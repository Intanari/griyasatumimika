<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('program');
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone');
            $table->unsignedBigInteger('amount');
            $table->text('message')->nullable();
            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->string('qr_string', 1000)->nullable();
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
