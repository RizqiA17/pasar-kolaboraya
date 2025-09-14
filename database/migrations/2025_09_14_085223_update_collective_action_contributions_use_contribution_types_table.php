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
        Schema::table('collective_action_contributions', function (Blueprint $table) {
            // Drop the enum column
            $table->dropColumn('contribution_type');
            
            // Add foreign key to contributions table
            $table->foreignId('contribution_id')->after('user_id')->constrained('contributions')->onDelete('cascade');
            
            // Add index for performance
            $table->index('contribution_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collective_action_contributions', function (Blueprint $table) {
            // Drop foreign key and index
            $table->dropForeign(['contribution_id']);
            $table->dropIndex(['contribution_id']);
            $table->dropColumn('contribution_id');
            
            // Add back the enum column
            $table->enum('contribution_type', ['volunteer', 'funding', 'expertise', 'resources', 'promotion', 'other'])->after('user_id');
        });
    }
};
