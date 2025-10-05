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
        // Add contribution_custom_type field to collective_action_contributions table
        Schema::table('collective_action_contributions', function (Blueprint $table) {
            $table->string('contribution_custom_type')->nullable()->after('contribution_id');
        });

        // Add contribution_custom_type field to ecosystem_contributions table
        Schema::table('ecosystem_contributions', function (Blueprint $table) {
            $table->string('contribution_custom_type')->nullable()->after('contribution_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove contribution_custom_type field from collective_action_contributions table
        Schema::table('collective_action_contributions', function (Blueprint $table) {
            $table->dropColumn('contribution_custom_type');
        });

        // Remove contribution_custom_type field from ecosystem_contributions table
        Schema::table('ecosystem_contributions', function (Blueprint $table) {
            $table->dropColumn('contribution_custom_type');
        });
    }
};
