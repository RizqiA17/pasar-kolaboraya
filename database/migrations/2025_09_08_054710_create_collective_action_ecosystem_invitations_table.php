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
        Schema::create('collective_action_ecosystem_invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collective_action_id');
            $table->unsignedBigInteger('ecosystem_id');
            $table->unsignedBigInteger('invited_by');
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->text('invitation_message')->nullable();
            $table->text('response_message')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Add foreign keys with custom names
            $table->foreign('collective_action_id', 'ca_eco_inv_action_fk')
                  ->references('id')->on('collective_actions')->onDelete('cascade');
            $table->foreign('ecosystem_id', 'ca_eco_inv_ecosystem_fk')
                  ->references('id')->on('ecosystems')->onDelete('cascade');
            $table->foreign('invited_by', 'ca_eco_inv_user_fk')
                  ->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['collective_action_id', 'ecosystem_id'], 'ca_eco_inv_unique');
            
            // Add indexes
            $table->index('collective_action_id', 'ca_inv_action_idx');
            $table->index('ecosystem_id', 'ca_inv_ecosystem_idx');
            $table->index('status', 'ca_inv_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_action_ecosystem_invitations');
    }
};
