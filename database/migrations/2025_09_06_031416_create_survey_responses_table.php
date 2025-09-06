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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kategori Koneksi
            $table->integer('jumlah_koneksi')->nullable();
            $table->text('jumlah_koneksi_alasan')->nullable();
            $table->integer('rata_kualitas_koneksi')->nullable(); // 1-5
            $table->text('rata_kualitas_koneksi_alasan')->nullable();
            $table->integer('keluasan_jejaring')->nullable();
            $table->text('keluasan_jejaring_alasan')->nullable();
            
            // Kategori Kolaborasi  
            $table->integer('kualitas_kolaborasi')->nullable(); // 1-5
            $table->text('kualitas_kolaborasi_alasan')->nullable();
            $table->integer('keragaman_kolaborator')->nullable();
            $table->text('keragaman_kolaborator_alasan')->nullable();
            $table->integer('jumlah_proyek_kolaborasi')->nullable();
            $table->text('jumlah_proyek_kolaborasi_alasan')->nullable();
            $table->integer('tingkat_kolaborasi')->nullable(); // 1-5
            $table->text('tingkat_kolaborasi_alasan')->nullable();
            $table->json('sumber_daya_disumbangkan')->nullable(); // Array of resources
            $table->text('sumber_daya_disumbangkan_alasan')->nullable();
            
            // Kategori Aksi
            $table->integer('jumlah_aksi_besar')->nullable();
            $table->text('jumlah_aksi_besar_alasan')->nullable();
            $table->integer('jumlah_aksi_sedang')->nullable();
            $table->text('jumlah_aksi_sedang_alasan')->nullable();
            $table->integer('jumlah_aksi_kecil')->nullable();
            $table->text('jumlah_aksi_kecil_alasan')->nullable();
            
            $table->timestamps();
            
            // Ensure one response per user per survey
            $table->unique(['survey_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
