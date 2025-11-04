<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SystemSettingSeeder::class,
            InterestSeeder::class,
            SkillSeeder::class,
            ContributionSeeder::class,
            EventCategorySeeder::class,
            PeranSeeder::class,
	    CustomUserSeeder::class,
        ]);
    }
}
