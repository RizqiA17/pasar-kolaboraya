<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // User Interests
        Schema::create('user_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('interest_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1); // Level of interest (1-5)
            $table->timestamps();
        });

        // User Skills
        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1); // Proficiency level (1-5)
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // User Contributions
        Schema::create('user_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contribution_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });


    }

    public function down()
    {
        Schema::dropIfExists('user_contributions');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('user_interests');
    }
};
