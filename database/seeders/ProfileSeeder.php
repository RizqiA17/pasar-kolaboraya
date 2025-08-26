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
                'bio' => fake()->paragraph(),
                'location' => fake()->city(),
                'birthday' => fake()->date(),
            ]);
        });
    }
}
