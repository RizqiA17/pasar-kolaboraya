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
        Schema::create('collective_action_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_action_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('contribution_type', ['volunteer', 'funding', 'expertise', 'resources', 'promotion', 'other']);
            $table->text('contribution_description');
            $table->decimal('contribution_amount', 10, 2)->nullable(); // For funding contributions
            $table->json('contribution_details')->nullable(); // Additional details as JSON
            $table->enum('status', ['offered', 'accepted', 'completed', 'declined'])->default('offered');
            $table->timestamps();
            
            $table->unique(['collective_action_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_action_users');
    }
};
