<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Interest;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = Skill::all();
        $interests = Interest::all();

        User::all()->each(function ($user) use ($skills, $interests) {
            // Check if profile already exists for this user
            if ($user->profile) {
                return; // Skip if profile already exists
            }

            $profile = Profile::create([
                'user_id' => $user->id,
                'organization' => fake()->company(),
                'phone' => fake()->phoneNumber(),
                'social_media' => [
                    'twitter' => fake()->userName(),
                    'linkedin' => fake()->userName(),
                    'github' => fake()->userName(),
                ],
                'vision' => fake()->paragraph(),
                'profile_photo' => null,
                'banner' => null,
            ]);

            // Attach random skills to profile (3-7 skills)
            if ($skills->count() > 0) {
                $randomSkills = $skills->random(fake()->numberBetween(3, min(7, $skills->count())));
                $profile->skills()->attach($randomSkills->pluck('id')->toArray());
            }

            // Attach random interests to profile (2-5 interests)
            if ($interests->count() > 0) {
                $randomInterests = $interests->random(fake()->numberBetween(2, min(5, $interests->count())));
                $profile->interests()->attach($randomInterests->pluck('id')->toArray());
            }
        });

        $this->command->info('Profile seeder completed successfully!');
    }
}
