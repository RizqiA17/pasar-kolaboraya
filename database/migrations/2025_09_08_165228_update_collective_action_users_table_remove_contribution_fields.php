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
        Schema::table('collective_action_users', function (Blueprint $table) {
            // Drop contribution-related columns
            $table->dropColumn([
                'contribution_type',
                'contribution_description', 
                'contribution_amount',
                'contribution_details'
            ]);
            
            // Add new columns for user membership management
            $table->foreignId('ecosystem_id')->nullable()->constrained()->onDelete('set null')->after('user_id');
            $table->enum('role', ['admin', 'member', 'contributor'])->default('member')->after('ecosystem_id');
            $table->enum('join_type', ['ecosystem', 'direct', 'invitation'])->default('direct')->after('role');
            $table->text('join_reason')->nullable()->after('join_type');
            $table->timestamp('joined_at')->nullable()->after('join_reason');
            
            // Update status enum to match membership status
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active')->change();
            
            // Add indexes for performance
            $table->index('ecosystem_id');
            $table->index('role');
            $table->index('status');
            $table->index('join_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collective_action_users', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'ecosystem_id',
                'role',
                'join_type', 
                'join_reason',
                'joined_at'
            ]);
            
            // Drop indexes
            $table->dropIndex(['ecosystem_id']);
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
            $table->dropIndex(['join_type']);
            
            // Add back contribution columns
            $table->enum('contribution_type', ['volunteer', 'funding', 'expertise', 'resources', 'promotion', 'other'])->after('user_id');
            $table->text('contribution_description')->after('contribution_type');
            $table->decimal('contribution_amount', 10, 2)->nullable()->after('contribution_description');
            $table->json('contribution_details')->nullable()->after('contribution_amount');
            
            // Revert status enum
            $table->enum('status', ['offered', 'accepted', 'completed', 'declined'])->default('offered')->change();
        });
    }
};