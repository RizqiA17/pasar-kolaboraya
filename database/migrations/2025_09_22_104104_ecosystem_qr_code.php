<?php

use App\Models\Ecosystem;
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
            $table->string('qr_code', 6)->after('auto_join_collective_actions');
        });
        Ecosystem::all()->each(function ($ecosystem) {
            $ecosystem->update([
                'qr_code' => ''.\Str::random(6),
            ]);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecosystems', function (Blueprint $table) {
            //
        });
    }
};
