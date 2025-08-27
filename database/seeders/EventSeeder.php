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
            // Get a random user as event creator
            $creator = $users->random();
            
            $event = Event::create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'start_date' => fake()->dateTimeBetween('now', '+2 months'),
                'end_date' => fake()->dateTimeBetween('+2 months', '+4 months'),
                'banner' => null, // You can set a default banner image if needed
                'location' => fake()->city(),
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
                'status' => fake()->randomElement(['draft', 'published', 'completed']),
                'created_by' => $creator->id,
                'max_participants' => fake()->numberBetween(10, 50),
            ]);

            // Add creator as organizer
            $event->participants()->attach($creator->id, [
                'role' => 'organizer',
                'status' => 'approved'
            ]);

            // Attach 3-7 random participants to each event
            $participants = $users->where('id', '!=', $creator->id)->random(fake()->numberBetween(3, 7));
            foreach ($participants as $participant) {
                $event->participants()->attach($participant->id, [
                    'role' => 'participant',
                    'status' => fake()->randomElement(['pending', 'approved', 'rejected'])
                ]);
            }
        }
    }
}
