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
        // Add custom name field to user_interests table
        Schema::table('user_interests', function (Blueprint $table) {
            $table->string('custom_name')->nullable()->after('interest_id');
            $table->foreignId('interest_id')->nullable()->change();
        });

        // Add custom name field to user_skills table
        Schema::table('user_skills', function (Blueprint $table) {
            $table->string('custom_name')->nullable()->after('skill_id');
            $table->foreignId('skill_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove custom name fields and restore foreign key constraints
        Schema::table('user_interests', function (Blueprint $table) {
            $table->dropColumn('custom_name');
            $table->foreignId('interest_id')->nullable(false)->change();
        });

        Schema::table('user_skills', function (Blueprint $table) {
            $table->dropColumn('custom_name');
            $table->foreignId('skill_id')->nullable(false)->change();
        });
    }
};
