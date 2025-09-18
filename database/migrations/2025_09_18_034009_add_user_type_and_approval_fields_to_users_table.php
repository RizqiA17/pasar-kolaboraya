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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['partisipan', 'tamu', 'komunitas'])->after('email');
            $table->string('registration_key')->nullable()->after('user_type');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('registration_key');
            $table->string('assigned_role')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('assigned_role');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
            $table->text('approval_reason')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'user_type',
                'registration_key',
                'approval_status',
                'assigned_role',
                'approved_at',
                'approved_by',
                'approval_reason'
            ]);
        });
    }
};
