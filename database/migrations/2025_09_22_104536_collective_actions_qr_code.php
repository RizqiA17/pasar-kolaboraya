<?php

use App\Models\CollectiveAction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collective_actions', function (Blueprint $table) {
            $table->string('qr_code', 6)->after('collaboration_terms');
        });
        CollectiveAction::all()->each(function ($ecosystem) {
            $ecosystem->update([
                'qr_code' => \Str::random(6),
            ]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collective_actions', function (Blueprint $table) {
            //
        });
    }
};
