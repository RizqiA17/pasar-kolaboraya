<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ecosystem;
use App\Models\Contribution;
use Illuminate\Database\Seeder;
use App\Models\EcosystemContribution;
use Illuminate\Support\Facades\Cache;

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
        $contributions = Cache::tags('contributions')->remember(
            'contributions:list_array',
            3600,
            function () {
                return Contribution::select('id', 'name', 'created_at')
                    ->withCount('profiles')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
            }
        );

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
                'Siap menjadi koordinator lapangan untuk kegiatan komunitas.',
                'Menyediakan waktu untuk mentoring dan pendampingan anggota baru.',
                'Bersedia membantu dalam event management dan logistik kegiatan.',
                'Siap menjadi fasilitator dalam workshop dan pelatihan.',
                'Menyediakan waktu untuk riset dan pengumpulan data lapangan.',
                'Bersedia menjadi translator untuk materi internasional.',
                'Siap membantu dalam administrasi dan dokumentasi kegiatan.',
            ],
            'funding' => [
                'Kontribusi dana untuk mendukung operasional dan program ekosistem.',
                'Pendanaan untuk pengembangan proyek-proyek inovatif dalam ekosistem.',
                'Dukungan finansial untuk kegiatan pelatihan dan workshop.',
                'Sponsorship untuk event dan konferensi ekosistem.',
                'Dana untuk pengadaan peralatan dan infrastruktur yang dibutuhkan.',
                'Pendanaan untuk riset dan pengembangan solusi baru.',
                'Dukungan finansial untuk program beasiswa dan pelatihan.',
                'Kontribusi dana untuk kegiatan sosial dan kemanusiaan.',
                'Pendanaan untuk pengembangan platform digital ekosistem.',
                'Dukungan finansial untuk program mentoring dan coaching.',
            ],
            'expertise' => [
                'Berbagi keahlian dan pengetahuan dalam bidang spesialisasi saya.',
                'Menyediakan konsultasi dan mentoring untuk anggota ekosistem.',
                'Kontribusi keahlian teknis untuk pengembangan solusi inovatif.',
                'Menyediakan training dan workshop dalam bidang keahlian saya.',
                'Berbagi pengalaman dan best practices dari proyek sebelumnya.',
                'Menyediakan konsultasi strategis untuk pengembangan ekosistem.',
                'Kontribusi keahlian dalam riset dan analisis data.',
                'Menyediakan mentoring untuk startup dan entrepreneur muda.',
                'Berbagi keahlian dalam manajemen proyek dan organisasi.',
                'Menyediakan konsultasi hukum dan regulasi yang relevan.',
            ],
            'resources' => [
                'Menyediakan fasilitas dan peralatan yang dibutuhkan ekosistem.',
                'Kontribusi sumber daya fisik untuk mendukung kegiatan.',
                'Berbagi akses ke infrastruktur dan tools yang dimiliki.',
                'Menyediakan ruang meeting dan co-working space.',
                'Berbagi akses ke software dan tools profesional.',
                'Menyediakan kendaraan untuk transportasi kegiatan.',
                'Berbagi akses ke laboratorium dan fasilitas riset.',
                'Menyediakan peralatan audio visual untuk presentasi.',
                'Berbagi akses ke database dan sumber informasi premium.',
                'Menyediakan peralatan untuk produksi konten digital.',
            ],
            'promotion' => [
                'Membantu mempromosikan ekosistem melalui jaringan dan media sosial.',
                'Kontribusi dalam strategi marketing dan komunikasi ekosistem.',
                'Menyebarluaskan informasi dan pencapaian ekosistem ke publik.',
                'Membuat konten kreatif untuk promosi ekosistem.',
                'Menggunakan jaringan profesional untuk memperluas reach ekosistem.',
                'Menyediakan layanan PR dan media relations.',
                'Membantu dalam pengembangan brand identity ekosistem.',
                'Menyediakan layanan fotografi dan videografi untuk dokumentasi.',
                'Membantu dalam pengembangan website dan platform digital.',
                'Menyediakan layanan copywriting dan content creation.',
            ],
            'other' => [
                'Kontribusi khusus lainnya yang dapat mendukung ekosistem.',
                'Dukungan dalam bentuk lain yang relevan dengan tujuan ekosistem.',
                'Kontribusi unik yang dapat memberikan nilai tambah.',
                'Menyediakan layanan terjemahan dan interpretasi.',
                'Berbagi akses ke jaringan internasional dan partnership.',
                'Menyediakan layanan legal dan compliance.',
                'Berbagi akses ke funding dan investment opportunities.',
                'Menyediakan layanan desain dan creative services.',
                'Berbagi akses ke teknologi dan inovasi terbaru.',
                'Menyediakan layanan konsultasi bisnis dan strategi.',
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
                'hours_per_week' => fake()->numberBetween(5, 40),
                'skills' => fake()->randomElements([
                    'Project Management', 'Event Planning', 'Community Outreach', 'Data Analysis',
                    'Social Media Management', 'Translation', 'Teaching', 'Mentoring',
                    'Research', 'Writing', 'Design', 'Photography', 'Videography',
                    'Public Speaking', 'Fundraising', 'Administration'
                ], fake()->numberBetween(2, 5)),
                'availability_days' => fake()->randomElements(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], fake()->numberBetween(2, 5)),
                'languages' => fake()->randomElements(['Indonesian', 'English', 'Mandarin', 'Japanese', 'Korean', 'Arabic'], fake()->numberBetween(1, 3)),
                'previous_experience' => fake()->sentence(),
            ],
            'funding' => [
                'payment_method' => fake()->randomElement(['bank_transfer', 'digital_wallet', 'cash', 'cryptocurrency']),
                'frequency' => fake()->randomElement(['one-time', 'monthly', 'quarterly', 'annually']),
                'purpose' => fake()->randomElement([
                    'Program Development', 'Equipment Purchase', 'Training & Workshop',
                    'Research & Development', 'Event Organization', 'Infrastructure',
                    'Scholarship Program', 'Emergency Fund', 'Marketing & Promotion'
                ]),
                'amount_range' => fake()->randomElement(['< 1 juta', '1-5 juta', '5-10 juta', '10-50 juta', '> 50 juta']),
                'conditions' => fake()->sentence(),
            ],
            'expertise' => [
                'specialization' => fake()->randomElement([
                    'Software Development', 'Digital Marketing', 'Data Science', 'Project Management',
                    'Financial Analysis', 'Legal Consulting', 'Healthcare', 'Education',
                    'Environmental Science', 'Engineering', 'Design', 'Research',
                    'Business Strategy', 'Human Resources', 'Operations Management'
                ]),
                'years_experience' => fake()->numberBetween(1, 25),
                'certifications' => fake()->randomElements([
                    'PMP', 'AWS Certified', 'Google Analytics', 'Scrum Master',
                    'CPA', 'CFA', 'PhD', 'MBA', 'ISO 9001', 'Six Sigma'
                ], fake()->numberBetween(0, 3)),
                'previous_projects' => fake()->sentence(),
                'consultation_type' => fake()->randomElement(['one-on-one', 'group', 'workshop', 'webinar']),
            ],
            'resources' => [
                'resource_type' => fake()->randomElement(['equipment', 'facility', 'software', 'materials', 'vehicle', 'space']),
                'condition' => fake()->randomElement(['new', 'excellent', 'good', 'used', 'refurbished']),
                'availability_period' => fake()->numberBetween(1, 12) . ' months',
                'location' => fake()->city() . ', ' . fake()->state(),
                'maintenance' => fake()->randomElement(['provided', 'user responsibility', 'shared']),
                'usage_terms' => fake()->sentence(),
            ],
            'promotion' => [
                'platforms' => fake()->randomElements([
                    'Instagram', 'Facebook', 'Twitter', 'LinkedIn', 'YouTube', 'TikTok',
                    'Website', 'Blog', 'Newsletter', 'Podcast', 'Events', 'Press'
                ], fake()->numberBetween(2, 4)),
                'audience_reach' => fake()->numberBetween(100, 100000),
                'content_type' => fake()->randomElements([
                    'Social Media Posts', 'Articles', 'Videos', 'Infographics',
                    'Webinars', 'Podcasts', 'Case Studies', 'Testimonials'
                ], fake()->numberBetween(1, 3)),
                'target_audience' => fake()->randomElement([
                    'General Public', 'Professionals', 'Students', 'Entrepreneurs',
                    'Researchers', 'Government', 'NGOs', 'International Community'
                ]),
                'content_frequency' => fake()->randomElement(['daily', 'weekly', 'monthly', 'as needed']),
            ],
        ];

        return array_merge($baseDetails, $categorySpecificDetails[$category] ?? []);
    }
}
