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
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->nullable();
            }

            if (!Schema::hasColumn('notifications', 'message')) {
                $table->text('message');
            }

            if (!Schema::hasColumn('notifications', 'redirect_url')) {
                $table->string('redirect_url')->nullable();
            }

            if (!Schema::hasColumn('notifications', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }

            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
             $table->dropColumn([
                'title',
                'message',
                'redirect_url',
                'is_read',
                'read_at',
            ]);
        });
    }
};
