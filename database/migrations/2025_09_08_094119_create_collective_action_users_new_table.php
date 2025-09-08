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
        Schema::create('collective_action_users_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_action_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ecosystem_id')->nullable()->constrained()->onDelete('set null'); // Nullable for direct users
            $table->enum('role', ['admin', 'member', 'contributor'])->default('member');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->enum('join_type', ['ecosystem', 'direct', 'invitation'])->default('direct');
            $table->text('join_reason')->nullable(); // User's reason for joining
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate memberships
            $table->unique(['collective_action_id', 'user_id'], 'ca_users_new_unique');
            
            // Indexes for performance
            $table->index('collective_action_id', 'ca_users_new_action_idx');
            $table->index('user_id', 'ca_users_new_user_idx');
            $table->index('ecosystem_id', 'ca_users_new_ecosystem_idx');
            $table->index('role', 'ca_users_new_role_idx');
            $table->index('status', 'ca_users_new_status_idx');
            $table->index('join_type', 'ca_users_new_join_type_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_action_users_new');
    }
};