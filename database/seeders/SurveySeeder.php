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

        // Create a test survey
        Survey::create([
            'name' => 'Survey Kolaborasi Komunitas 2024',
            'description' => 'Survey untuk mengukur tingkat kolaborasi dan koneksi dalam komunitas Pasar Kolaboraya. Data yang dikumpulkan akan membantu kami memahami pola kolaborasi dan membuat strategi yang lebih baik untuk masa depan.',
            'is_active' => true,
            'created_by' => $superAdmin->id,
            'started_at' => now(),
        ]);

        $this->command->info('Survey seeder completed successfully!');
    }
}