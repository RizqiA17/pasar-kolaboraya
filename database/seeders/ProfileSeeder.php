<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            Profile::create([
                'user_id' => $user->id,
                'organization' => fake()->company(),
                'phone' => fake()->phoneNumber(),
                'social_media' => json_encode([
                    'twitter' => fake()->userName(),
                    'linkedin' => fake()->userName(),
                    'github' => fake()->userName(),
                ]),
                'skills' => implode(', ', fake()->words(5)),
                'interests' => implode(', ', fake()->words(4)),
                'contributions' => fake()->paragraph(),
                'vision' => fake()->paragraph(),
            ]);
        });
    }
}
