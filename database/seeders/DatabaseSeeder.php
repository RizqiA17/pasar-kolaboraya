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
        $this->command->info('Starting database seeding...');
        
        $this->call([
            // System Settings (must be first)
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
            
            // Ecosystem Builders (after users and skills)
            EcosystemBuilderSeeder::class,
            
            // Collective Actions (after ecosystems)
            CollectiveActionSeeder::class,
            
            // Ecosystem Contributions (after ecosystems and users)
            EcosystemContributionSeeder::class,
            
            // Survey Data
            SurveySeeder::class,
            SurveyResponseSeeder::class,
            
            // Optional seeders (uncomment if needed)
            // EventSeeder::class,
            // CollaborationSeeder::class,
            // TodoSeeder::class,
            // CommentSeeder::class,
        ]);
        
        $this->command->info('Database seeding completed successfully!');
    }
}
