<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('assigned_role', 'Ekosistem Builder')
            ->update(['assigned_role' => 'Ecosystem Builder']);
    }

    /**
     * Kembalikan perubahan (opsional).
     */
    public function down(): void
    {
        DB::table('users')
            ->where('assigned_role', 'Ecosystem Builder')
            ->update(['assigned_role' => 'Ekosistem Builder']);
    }
};
