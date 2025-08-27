<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        // Create 10 events
        foreach(range(1, 10) as $index) {
            $event = Event::create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'start_date' => fake()->dateTimeBetween('now', '+2 months'),
                'end_date' => fake()->dateTimeBetween('+2 months', '+4 months'),
                'banner' => null, // You can set a default banner image if needed
                'location' => fake()->city(),
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
            ]);

            // Attach 3-7 random participants to each event
            $participants = $users->random(fake()->numberBetween(3, 7));
            $event->participants()->attach($participants->pluck('id'));
        }
    }
}
