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
        Schema::table('collective_action_ecosystem_invitations', function (Blueprint $table) {
            // Add role field to distinguish between admin and member
            $table->enum('role', ['admin', 'member'])->default('admin')->after('status');
            
            // Add index for role
            $table->index('role', 'ca_eco_inv_role_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collective_action_ecosystem_invitations', function (Blueprint $table) {
            $table->dropIndex('ca_eco_inv_role_idx');
            $table->dropColumn('role');
        });
    }
};