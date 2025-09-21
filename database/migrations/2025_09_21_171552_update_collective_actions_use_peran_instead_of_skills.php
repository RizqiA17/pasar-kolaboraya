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
        // This migration is for future use if collective actions need role-based features
        // Currently collective actions don't have specific role requirements
        // but this migration is prepared for future enhancements
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No changes to revert for this migration
    }
};
