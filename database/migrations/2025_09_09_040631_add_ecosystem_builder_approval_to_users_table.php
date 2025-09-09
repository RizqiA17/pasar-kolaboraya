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
            $table->enum('ecosystem_builder_status', ['pending', 'approved', 'rejected'])->nullable()->after('is_ecosystem_builder');
            $table->text('ecosystem_builder_reason')->nullable()->after('ecosystem_builder_status');
            $table->timestamp('ecosystem_builder_approved_at')->nullable()->after('ecosystem_builder_reason');
            $table->unsignedBigInteger('ecosystem_builder_approved_by')->nullable()->after('ecosystem_builder_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ecosystem_builder_status',
                'ecosystem_builder_reason',
                'ecosystem_builder_approved_at',
                'ecosystem_builder_approved_by'
            ]);
        });
    }
};
