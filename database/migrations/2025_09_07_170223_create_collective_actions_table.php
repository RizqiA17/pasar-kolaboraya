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
        Schema::create('collective_actions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('scale', ['kecil', 'sedang', 'besar']); // small, medium, large scale
            $table->enum('scope', ['local', 'national', 'international']);
            $table->text('goals'); // Goals/objectives of the action
            $table->json('required_resources')->nullable(); // Required resources (funding, skills, etc.)
            $table->json('ecosystem_ids'); // Array of participating ecosystem IDs
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location')->nullable();
            $table->enum('status', ['draft', 'planning', 'active', 'completed', 'cancelled'])->default('draft');
            $table->integer('min_ecosystems')->default(3); // Minimum ecosystems required
            $table->text('collaboration_terms')->nullable(); // Terms for collaboration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_actions');
    }
};
