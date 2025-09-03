<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For this approach, we'll keep the unique constraint but handle it in the application layer
        // The unique constraint will remain, but we'll modify the validation rules to handle soft deleted users
        // This is a simpler approach that works reliably across all database systems
        
        // We don't need to modify the database structure
        // The application layer will handle the uniqueness validation properly
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No changes to reverse since we didn't modify the database structure
    }
};
