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
        // Drop existing pivot tables
        Schema::dropIfExists('user_contributions');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('user_interests');

        // Recreate user_interests with profile_id
        Schema::create('user_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('interest_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1); // Level of interest (1-3)
            $table->timestamps();
        });

        // Recreate user_skills with profile_id
        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1); // Proficiency level (1-4)
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // Recreate user_contributions with profile_id
        Schema::create('user_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('contribution_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop new pivot tables
        Schema::dropIfExists('user_contributions');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('user_interests');

        // Recreate original pivot tables with user_id
        Schema::create('user_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('interest_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->timestamps();
        });

        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('user_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contribution_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }
};
