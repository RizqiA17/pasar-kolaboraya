<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('connection_qrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('qr_code')->unique();
            $table->enum('type', ['initiator', 'responder']); // initiator = user A, responder = user B
            $table->string('target_qr_code')->nullable(); // For responder type, links to initiator's QR
            $table->foreignId('pasar_kolaboraya_id')->constrained('pasar_kolaborayas')->cascadeOnDelete();
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            $table->index(['qr_code', 'is_used']);
            $table->index(['user_id', 'type']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_qrs');
    }
};