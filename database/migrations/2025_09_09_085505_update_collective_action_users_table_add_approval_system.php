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
        // Find the correct table name for collective action users
        $tableName = 'collective_action_users';
        if (Schema::hasTable('collective_action_users_new')) {
            $tableName = 'collective_action_users_new';
        }
        
        Schema::table($tableName, function (Blueprint $table) {
            // Add approval-related fields
            $table->timestamp('approval_requested_at')->nullable()->after('joined_at');
            $table->timestamp('approved_at')->nullable()->after('approval_requested_at');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
            $table->text('admin_notes')->nullable()->after('approved_by');
            
            // Update status enum to include 'pending_approval' and 'rejected'
            $table->enum('status', ['active', 'inactive', 'pending', 'pending_approval', 'rejected'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Find the correct table name for collective action users
        $tableName = 'collective_action_users';
        if (Schema::hasTable('collective_action_users_new')) {
            $tableName = 'collective_action_users_new';
        }
        
        Schema::table($tableName, function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approval_requested_at', 'approved_at', 'approved_by', 'admin_notes']);
            
            // Restore original status enum
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active')->change();
        });
    }
};
