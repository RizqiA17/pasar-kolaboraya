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
        Schema::table('pasar_kolaborayas', function (Blueprint $table) {
            $table->string('qr_code', 50)->unique()->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasar_kolaborayas', function (Blueprint $table) {
            $table->dropColumn('qr_code');
        });
    }
};
