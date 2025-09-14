<?php

namespace Database\Seeders;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionEcosystemInvitation;
use App\Models\CollectiveActionUser;
use App\Models\CollectiveActionContribution;
use App\Models\Ecosystem;
use App\Models\User;
use App\Models\Contribution;
use Illuminate\Database\Seeder;

class CollectiveActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if collective actions already exist
        if (CollectiveAction::count() > 0) {
            $this->command->info('Collective actions already exist. Skipping collective action creation.');
            return;
        }

        $ecosystems = Ecosystem::where('is_active', true)->get();
        $users = User::where('role', 'user')->get();
        $contributions = Contribution::all();

        if ($ecosystems->isEmpty()) {
            $this->command->warn('No active ecosystems found. Creating collective actions without ecosystem participation.');
            $ecosystems = collect(); // Empty collection
        }

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Create sample collective actions
        $collectiveActions = [
            [
                'title' => 'Kampanye Digitalisasi UMKM',
                'description' => 'Program kolaboratif untuk membantu UMKM dalam proses digitalisasi bisnis mereka melalui pelatihan, pendampingan, dan dukungan teknologi.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Melatih 1000 UMKM dalam digitalisasi, Meningkatkan penjualan online UMKM 50%, Membuat platform marketplace lokal',
                'required_resources' => [
                    'Expertise: Digital Marketing, E-commerce',
                    'Funding: Rp 500 juta',
                    'Volunteers: 50 orang',
                    'Resources: Laptop, Internet, Training materials'
                ],
                'start_date' => now()->addDays(30),
                'end_date' => now()->addMonths(6),
                'location' => 'Jakarta, Indonesia',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'status' => 'planning',
                'min_ecosystems' => 3,
                'collaboration_terms' => 'Semua peserta harus berkomitmen untuk berpartisipasi aktif selama 6 bulan dan melaporkan progress bulanan.',
            ],
            [
                'title' => 'Program Pendidikan Berkelanjutan',
                'description' => 'Inisiatif untuk meningkatkan akses pendidikan berkualitas di daerah terpencil melalui teknologi dan kolaborasi komunitas.',
                'scale' => 'sedang',
                'scope' => 'local',
                'goals' => 'Membangun 10 pusat belajar digital, Melatih 200 guru lokal, Menyediakan akses internet untuk 1000 siswa',
                'required_resources' => [
                    'Expertise: Pendidikan, Teknologi',
                    'Funding: Rp 200 juta',
                    'Volunteers: 30 orang',
                    'Resources: Laptop, Tablet, Internet, Buku'
                ],
                'start_date' => now()->addDays(15),
                'end_date' => now()->addMonths(4),
                'location' => 'Bandung, Indonesia',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Fokus pada sustainability dan transfer knowledge ke komunitas lokal.',
            ],
            [
                'title' => 'Inovasi Teknologi Hijau',
                'description' => 'Proyek kolaboratif untuk mengembangkan solusi teknologi ramah lingkungan yang dapat diimplementasikan di tingkat komunitas.',
                'scale' => 'kecil',
                'scope' => 'local',
                'goals' => 'Mengembangkan 5 prototipe teknologi hijau, Melatih 50 warga dalam penggunaan teknologi, Mengurangi emisi karbon 20% di area target',
                'required_resources' => [
                    'Expertise: Teknologi, Lingkungan',
                    'Funding: Rp 100 juta',
                    'Volunteers: 20 orang',
                    'Resources: Bahan baku, Peralatan, Laboratorium'
                ],
                'start_date' => now()->addDays(7),
                'end_date' => now()->addMonths(3),
                'location' => 'Yogyakarta, Indonesia',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Open source dan dapat direplikasi di komunitas lain.',
            ],
            [
                'title' => 'Aksi Kemanusiaan Bencana',
                'description' => 'Koordinasi bantuan kemanusiaan untuk daerah yang terkena bencana alam dengan fokus pada recovery dan resilience building.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Menyediakan bantuan untuk 5000 korban, Membangun 100 rumah tahan gempa, Melatih 200 relawan tanggap bencana',
                'required_resources' => [
                    'Expertise: Kemanusiaan, Konstruksi, Psikologi',
                    'Funding: Rp 1 miliar',
                    'Volunteers: 100 orang',
                    'Resources: Bahan bangunan, Makanan, Obat-obatan'
                ],
                'start_date' => now()->subDays(5),
                'end_date' => now()->addMonths(8),
                'location' => 'Palu, Indonesia',
                'latitude' => -0.8983,
                'longitude' => 119.8506,
                'status' => 'active',
                'min_ecosystems' => 4,
                'collaboration_terms' => 'Prioritas pada koordinasi dan efisiensi distribusi bantuan.',
            ],
        ];

        foreach ($collectiveActions as $actionData) {
            // Select random creator from approved ecosystem builders
            $creator = User::where('is_ecosystem_builder', true)
                          ->where('ecosystem_builder_status', 'approved')
                          ->inRandomOrder()
                          ->first();

            if (!$creator) {
                $creator = $users->random();
            }

            $collectiveAction = CollectiveAction::create([
                'title' => $actionData['title'],
                'description' => $actionData['description'],
                'scale' => $actionData['scale'],
                'scope' => $actionData['scope'],
                'goals' => $actionData['goals'],
                'required_resources' => $actionData['required_resources'],
                'created_by' => $creator->id,
                'start_date' => $actionData['start_date'],
                'end_date' => $actionData['end_date'],
                'location' => $actionData['location'],
                'latitude' => $actionData['latitude'],
                'longitude' => $actionData['longitude'],
                'status' => $actionData['status'],
                'min_ecosystems' => $actionData['min_ecosystems'],
                'collaboration_terms' => $actionData['collaboration_terms'],
            ]);

            // Invite ecosystems to participate (if any exist)
            if ($ecosystems->isNotEmpty()) {
                $ecosystemsToInvite = $ecosystems->random(min($actionData['min_ecosystems'] + 1, $ecosystems->count()));
                
                foreach ($ecosystemsToInvite as $ecosystem) {
                    CollectiveActionEcosystemInvitation::create([
                        'collective_action_id' => $collectiveAction->id,
                        'ecosystem_id' => $ecosystem->id,
                        'status' => fake()->randomElement(['accepted', 'accepted', 'pending']), // 66% accepted
                        'invited_by' => $creator->id,
                    ]);

                    // Add ecosystem members to collective action if invitation is accepted
                    if (fake()->boolean(66)) { // 66% chance
                        $collectiveAction->addEcosystemMembers($ecosystem, 'member');
                    }
                }
            }

            // Add creator as admin first
            $collectiveAction->addUser($creator, 'admin', 'Action creator');

            // Add some direct users (excluding creator)
            $directUsers = $users->where('id', '!=', $creator->id)->random(3);
            foreach ($directUsers as $user) {
                // Check if user is not already a member
                if (!$collectiveAction->isUserRegistered($user)) {
                    $collectiveAction->addUser($user, 'member', 'Direct join request');
                }
            }

            // Create some contributions
            if ($contributions->count() > 0) {
                $actionUsers = $collectiveAction->users()->get();
                foreach ($actionUsers->random(min(5, $actionUsers->count())) as $user) {
                    $contribution = $contributions->random();
                    
                    CollectiveActionContribution::create([
                        'collective_action_id' => $collectiveAction->id,
                        'user_id' => $user->id,
                        'contribution_id' => $contribution->id,
                        'contribution_description' => fake()->sentence(),
                        'contribution_amount' => $contribution->category === 'funding' ? fake()->numberBetween(100000, 5000000) : null,
                        'contribution_details' => [
                            'availability' => fake()->randomElement(['part-time', 'full-time']),
                            'duration' => fake()->numberBetween(1, 6) . ' months',
                            'experience_level' => fake()->randomElement(['beginner', 'intermediate', 'expert']),
                        ],
                        'status' => fake()->randomElement(['offered', 'accepted', 'completed']),
                        'offered_at' => now(),
                        'accepted_at' => fake()->boolean(70) ? now() : null,
                        'completed_at' => fake()->boolean(30) ? now() : null,
                    ]);
                }
            }

            $this->command->info("Created Collective Action: {$collectiveAction->title}");
        }

        $this->command->info('Collective Action seeder completed successfully!');
    }
}
