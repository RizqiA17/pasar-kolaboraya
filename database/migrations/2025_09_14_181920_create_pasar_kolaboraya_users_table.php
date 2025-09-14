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
        Schema::create('pasar_kolaboraya_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasar_kolaboraya_id')->constrained('pasar_kolaborayas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->foreignId('invited_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('join_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['pasar_kolaboraya_id', 'user_id']);
            $table->index(['status', 'pasar_kolaboraya_id']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasar_kolaboraya_users');
    }
};
