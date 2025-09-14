<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // System Settings
            SystemSettingSeeder::class,
            
            // Master Data
            InterestSeeder::class,
            SkillSeeder::class,
            ContributionSeeder::class,
            EventCategorySeeder::class,

            // User & Relations
            UserSeeder::class,
            ProfileSeeder::class,
            ConnectionSeeder::class,
            SuperAdminSeeder::class,
            
            // Container System
            ContainerSeeder::class,
            ContainerUserSeeder::class,
            
            // Pasar Kolaboraya System
            PasarKolaborayaSeeder::class,
            
            // EventSeeder::class,
            // CollaborationSeeder::class,
            // TodoSeeder::class,
            // CommentSeeder::class,
            
            // Ecosystem Builders
            EcosystemBuilderSeeder::class,
            
            // Survey Data
            SurveySeeder::class,
            SurveyResponseSeeder::class,
        ]);
    }
}
