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
        // Drop the old collective_action_members table
        Schema::dropIfExists('collective_action_members');
        
        // Drop the existing collective_action_users table if it exists
        Schema::dropIfExists('collective_action_users');
        
        // Rename the new table to a simpler name
        Schema::rename('collective_action_users_new', 'collective_action_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back to the new table name
        Schema::rename('collective_action_users', 'collective_action_users_new');
        
        // Recreate the old table (if needed for rollback)
        Schema::create('collective_action_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_action_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ecosystem_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            
            $table->unique(['collective_action_id', 'user_id'], 'ca_members_unique');
            $table->index('collective_action_id', 'ca_members_action_idx');
            $table->index('user_id', 'ca_members_user_idx');
            $table->index('ecosystem_id', 'ca_members_ecosystem_idx');
            $table->index('role', 'ca_members_role_idx');
            $table->index('status', 'ca_members_status_idx');
        });
    }
};