<?php

namespace Database\Seeders;

use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\User;
use App\Models\Contribution;
use Illuminate\Database\Seeder;

class EcosystemContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if ecosystem contributions already exist
        if (EcosystemContribution::count() > 0) {
            $this->command->info('Ecosystem contributions already exist. Skipping ecosystem contribution creation.');
            return;
        }

        $ecosystems = Ecosystem::where('is_active', true)->get();
        $users = User::where('role', 'user')->get();
        $contributions = Contribution::all();

        if ($ecosystems->isEmpty()) {
            $this->command->warn('No active ecosystems found. Skipping ecosystem contribution creation.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        if ($contributions->isEmpty()) {
            $this->command->error('No contributions found. Please run ContributionSeeder first.');
            return;
        }

        $contributionsCreated = 0;

        foreach ($ecosystems as $ecosystem) {
            // Get users who can contribute to this ecosystem
            $contributors = $users->filter(function ($user) use ($ecosystem) {
                return $ecosystem->canUserContribute($user);
            });

            // Create 3-8 contributions per ecosystem
            $numberOfContributions = fake()->numberBetween(3, 8);
            $selectedContributors = $contributors->random(min($numberOfContributions, $contributors->count()));

            foreach ($selectedContributors as $user) {
                $contribution = $contributions->random();
                
                $contributionData = [
                    'ecosystem_id' => $ecosystem->id,
                    'user_id' => $user->id,
                    'contribution_id' => $contribution->id,
                    'contribution_description' => $this->generateContributionDescription($contribution->category),
                    'contribution_amount' => $contribution->category === 'funding' ? fake()->numberBetween(50000, 2000000) : null,
                    'contribution_details' => $this->generateContributionDetails($contribution->category),
                    'status' => fake()->randomElement(['offered', 'accepted', 'completed']),
                    'offered_at' => now(),
                ];

                // Set accepted_at if status is accepted or completed
                if (in_array($contributionData['status'], ['accepted', 'completed'])) {
                    $contributionData['accepted_at'] = now();
                }

                // Set completed_at if status is completed
                if ($contributionData['status'] === 'completed') {
                    $contributionData['completed_at'] = now();
                }

                EcosystemContribution::create($contributionData);
                $contributionsCreated++;
            }
        }

        $this->command->info("Ecosystem Contribution seeder completed! Created {$contributionsCreated} contributions.");
    }

    /**
     * Generate contribution description based on category
     */
    private function generateContributionDescription(string $category): string
    {
        $descriptions = [
            'volunteer' => [
                'Saya siap membantu dengan tenaga dan waktu untuk mendukung kegiatan ekosistem.',
                'Bersedia menjadi relawan aktif dalam program-program yang dijalankan.',
                'Menyediakan waktu 10-15 jam per minggu untuk mendukung inisiatif ekosistem.',
            ],
            'funding' => [
                'Kontribusi dana untuk mendukung operasional dan program ekosistem.',
                'Pendanaan untuk pengembangan proyek-proyek inovatif dalam ekosistem.',
                'Dukungan finansial untuk kegiatan pelatihan dan workshop.',
            ],
            'expertise' => [
                'Berbagi keahlian dan pengetahuan dalam bidang spesialisasi saya.',
                'Menyediakan konsultasi dan mentoring untuk anggota ekosistem.',
                'Kontribusi keahlian teknis untuk pengembangan solusi inovatif.',
            ],
            'resources' => [
                'Menyediakan fasilitas dan peralatan yang dibutuhkan ekosistem.',
                'Kontribusi sumber daya fisik untuk mendukung kegiatan.',
                'Berbagi akses ke infrastruktur dan tools yang dimiliki.',
            ],
            'promotion' => [
                'Membantu mempromosikan ekosistem melalui jaringan dan media sosial.',
                'Kontribusi dalam strategi marketing dan komunikasi ekosistem.',
                'Menyebarluaskan informasi dan pencapaian ekosistem ke publik.',
            ],
            'other' => [
                'Kontribusi khusus lainnya yang dapat mendukung ekosistem.',
                'Dukungan dalam bentuk lain yang relevan dengan tujuan ekosistem.',
                'Kontribusi unik yang dapat memberikan nilai tambah.',
            ],
        ];

        $categoryDescriptions = $descriptions[$category] ?? $descriptions['other'];
        return fake()->randomElement($categoryDescriptions);
    }

    /**
     * Generate contribution details based on category
     */
    private function generateContributionDetails(string $category): array
    {
        $baseDetails = [
            'availability' => fake()->randomElement(['part-time', 'full-time', 'project-based']),
            'duration' => fake()->numberBetween(1, 12) . ' months',
            'experience_level' => fake()->randomElement(['beginner', 'intermediate', 'expert']),
        ];

        $categorySpecificDetails = [
            'volunteer' => [
                'hours_per_week' => fake()->numberBetween(5, 20),
                'skills' => fake()->words(3),
                'availability_days' => fake()->randomElements(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], 3),
            ],
            'funding' => [
                'payment_method' => fake()->randomElement(['bank_transfer', 'digital_wallet', 'cash']),
                'frequency' => fake()->randomElement(['one-time', 'monthly', 'quarterly']),
                'purpose' => fake()->sentence(),
            ],
            'expertise' => [
                'specialization' => fake()->jobTitle(),
                'years_experience' => fake()->numberBetween(1, 20),
                'certifications' => fake()->words(2),
            ],
            'resources' => [
                'resource_type' => fake()->randomElement(['equipment', 'facility', 'software', 'materials']),
                'condition' => fake()->randomElement(['new', 'good', 'used']),
                'availability_period' => fake()->numberBetween(1, 6) . ' months',
            ],
            'promotion' => [
                'platforms' => fake()->randomElements(['social_media', 'website', 'newsletter', 'events'], 2),
                'audience_reach' => fake()->numberBetween(100, 10000),
                'content_type' => fake()->randomElement(['posts', 'articles', 'videos', 'infographics']),
            ],
        ];

        return array_merge($baseDetails, $categorySpecificDetails[$category] ?? []);
    }
}
