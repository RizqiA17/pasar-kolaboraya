<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the super admin user
        $superAdmin = User::where('role', 'super_admin')->first();
        
        if (!$superAdmin) {
            $this->command->error('Super admin user not found. Please run UserSeeder first.');
            return;
        }

        // Check if surveys already exist
        if (Survey::count() > 0) {
            $this->command->info('Surveys already exist. Skipping survey creation.');
            return;
        }

        // Create primary active survey
        Survey::create([
            'name' => 'Survey Kolaborasi Komunitas 2025',
            'description' => 'Survey untuk mengukur tingkat kolaborasi, koneksi, dan dampak aksi kolektif dalam komunitas Pasar Kolaboraya. Data yang dikumpulkan akan membantu kami memahami pola kolaborasi dan membuat strategi yang lebih baik untuk pengembangan ekosistem.',
            'is_active' => true,
            'created_by' => $superAdmin->id,
            'started_at' => now()->startOfMonth(),
            'ended_at' => now()->addMonths(3)->endOfMonth(),
        ]);

        // Create historical survey (completed)
        Survey::create([
            'name' => 'Survey Baseline Komunitas 2024',
            'description' => 'Survey baseline untuk mengukur kondisi awal komunitas sebelum implementasi sistem Pasar Kolaboraya. Survey ini telah selesai dan hasilnya digunakan sebagai perbandingan.',
            'is_active' => false,
            'created_by' => $superAdmin->id,
            'started_at' => now()->subMonths(6)->startOfMonth(),
            'ended_at' => now()->subMonths(3)->endOfMonth(),
        ]);

        // Create upcoming survey (inactive)
        Survey::create([
            'name' => 'Survey Impact Assessment 2025',
            'description' => 'Survey untuk mengevaluasi dampak implementasi sistem kolaborasi dalam 6 bulan pertama. Survey ini akan diaktifkan setelah periode implementasi selesai.',
            'is_active' => false,
            'created_by' => $superAdmin->id,
            'started_at' => now()->addMonths(6)->startOfMonth(),
            'ended_at' => now()->addMonths(9)->endOfMonth(),
        ]);

        $this->command->info('Survey seeder completed successfully! Created 3 surveys.');
    }
}