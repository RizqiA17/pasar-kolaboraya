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
        Schema::create('ecosystems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('organization_name');
            $table->string('ecosystem_title');
            $table->json('issues_addressed'); // Array of interests/issues like existing interests
            $table->string('work_region'); // Working region/area
            $table->json('existing_roles'); // Array of existing skills/roles
            $table->json('needed_roles'); // Array of needed skills/roles  
            $table->integer('max_users')->nullable(); // Maximum users allowed
            $table->text('terms_conditions'); // Terms & conditions for joining
            $table->text('description')->nullable(); // Additional description
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecosystems');
    }
};
