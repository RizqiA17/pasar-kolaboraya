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
        Schema::create('collective_action_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_action_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ecosystem_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate memberships
            $table->unique(['collective_action_id', 'user_id'], 'ca_members_unique');
            
            // Indexes for performance
            $table->index('collective_action_id', 'ca_members_action_idx');
            $table->index('user_id', 'ca_members_user_idx');
            $table->index('ecosystem_id', 'ca_members_ecosystem_idx');
            $table->index('role', 'ca_members_role_idx');
            $table->index('status', 'ca_members_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_action_members');
    }
};