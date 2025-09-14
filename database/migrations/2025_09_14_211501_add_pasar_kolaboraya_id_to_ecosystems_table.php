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
        Schema::table('ecosystems', function (Blueprint $table) {
            $table->foreignId('pasar_kolaboraya_id')->nullable()->constrained('pasar_kolaborayas')->onDelete('cascade');
            $table->index('pasar_kolaboraya_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecosystems', function (Blueprint $table) {
            $table->dropForeign(['pasar_kolaboraya_id']);
            $table->dropIndex(['pasar_kolaboraya_id']);
            $table->dropColumn('pasar_kolaboraya_id');
        });
    }
};