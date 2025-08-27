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
            // Master Data
            InterestSeeder::class,
            SkillSeeder::class,
            ContributionSeeder::class,
            EventCategorySeeder::class,

            // User & Relations
            UserSeeder::class,
            ProfileSeeder::class,
            ConnectionSeeder::class,
            EventSeeder::class,
            CollaborationSeeder::class,
            TodoSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
