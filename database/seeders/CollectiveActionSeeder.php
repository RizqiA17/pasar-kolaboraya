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
use Illuminate\Support\Str;

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
        $pasarKolaboraya = \App\Models\PasarKolaboraya::where('status', 'active')->first();

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
            // Technology & Digital Transformation
            [
                'title' => 'Kampanye Digitalisasi UMKM Nasional',
                'description' => 'Program kolaboratif untuk membantu UMKM dalam proses digitalisasi bisnis mereka melalui pelatihan, pendampingan, dan dukungan teknologi.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Melatih 1000 UMKM dalam digitalisasi, Meningkatkan penjualan online UMKM 50%, Membuat platform marketplace lokal',
                'required_resources' => [
                    'Expertise: Digital Marketing, E-commerce, UI/UX Design',
                    'Funding: Rp 500 juta',
                    'Volunteers: 50 orang',
                    'Resources: Laptop, Internet, Training materials, Software licenses'
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
                'title' => 'Fintech untuk Inklusi Keuangan',
                'description' => 'Mengembangkan solusi fintech yang dapat diakses oleh masyarakat di daerah terpencil untuk meningkatkan inklusi keuangan.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Membuat 5 aplikasi fintech lokal, Melatih 300 agen keuangan digital, Menjangkau 10,000 pengguna baru',
                'required_resources' => [
                    'Expertise: Fintech Development, Financial Literacy, Mobile App Development',
                    'Funding: Rp 300 juta',
                    'Volunteers: 25 orang',
                    'Resources: Server, Development tools, Training materials'
                ],
                'start_date' => now()->addDays(20),
                'end_date' => now()->addMonths(5),
                'location' => 'Surabaya, Indonesia',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Fokus pada keamanan data dan kepatuhan regulasi keuangan.',
            ],

            // Education & Learning
            [
                'title' => 'Program Pendidikan Berkelanjutan Digital',
                'description' => 'Inisiatif untuk meningkatkan akses pendidikan berkualitas di daerah terpencil melalui teknologi dan kolaborasi komunitas.',
                'scale' => 'sedang',
                'scope' => 'local',
                'goals' => 'Membangun 10 pusat belajar digital, Melatih 200 guru lokal, Menyediakan akses internet untuk 1000 siswa',
                'required_resources' => [
                    'Expertise: Pendidikan, Teknologi, Curriculum Development',
                    'Funding: Rp 200 juta',
                    'Volunteers: 30 orang',
                    'Resources: Laptop, Tablet, Internet, Buku, Learning Management System'
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
                'title' => 'Vocational Training untuk Pemuda',
                'description' => 'Program pelatihan keterampilan untuk mengurangi pengangguran pemuda melalui kerjasama dengan industri lokal.',
                'scale' => 'kecil',
                'scope' => 'local',
                'goals' => 'Melatih 150 pemuda, Menciptakan 100 lapangan kerja baru, Membangun 3 pusat pelatihan',
                'required_resources' => [
                    'Expertise: Vocational Training, Industry Partnership, Career Counseling',
                    'Funding: Rp 150 juta',
                    'Volunteers: 15 orang',
                    'Resources: Workshop equipment, Training materials, Industry mentors'
                ],
                'start_date' => now()->addDays(10),
                'end_date' => now()->addMonths(3),
                'location' => 'Medan, Indonesia',
                'latitude' => 3.5952,
                'longitude' => 98.6722,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Kerjasama erat dengan industri lokal untuk penempatan kerja.',
            ],

            // Environmental & Sustainability
            [
                'title' => 'Inovasi Teknologi Hijau Komunitas',
                'description' => 'Proyek kolaboratif untuk mengembangkan solusi teknologi ramah lingkungan yang dapat diimplementasikan di tingkat komunitas.',
                'scale' => 'kecil',
                'scope' => 'local',
                'goals' => 'Mengembangkan 5 prototipe teknologi hijau, Melatih 50 warga dalam penggunaan teknologi, Mengurangi emisi karbon 20% di area target',
                'required_resources' => [
                    'Expertise: Teknologi, Lingkungan, Engineering',
                    'Funding: Rp 100 juta',
                    'Volunteers: 20 orang',
                    'Resources: Bahan baku, Peralatan, Laboratorium, Testing facilities'
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
                'title' => 'Konservasi Laut dan Pesisir',
                'description' => 'Program konservasi ekosistem laut dan pesisir dengan melibatkan komunitas nelayan dan wisatawan.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Melindungi 5 hektar terumbu karang, Melatih 100 nelayan sustainable fishing, Menciptakan 3 ekowisata',
                'required_resources' => [
                    'Expertise: Marine Biology, Conservation, Community Development',
                    'Funding: Rp 250 juta',
                    'Volunteers: 40 orang',
                    'Resources: Diving equipment, Monitoring tools, Educational materials'
                ],
                'start_date' => now()->addDays(25),
                'end_date' => now()->addMonths(6),
                'location' => 'Bali, Indonesia',
                'latitude' => -8.3405,
                'longitude' => 115.0920,
                'status' => 'planning',
                'min_ecosystems' => 3,
                'collaboration_terms' => 'Melibatkan komunitas lokal dan memastikan keberlanjutan ekonomi.',
            ],
            [
                'title' => 'Smart City untuk Kota Kecil',
                'description' => 'Implementasi teknologi smart city untuk meningkatkan efisiensi dan kualitas hidup di kota-kota kecil.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Mengimplementasikan smart city di 10 kota, Mengurangi traffic congestion 30%, Meningkatkan efisiensi energi 25%',
                'required_resources' => [
                    'Expertise: Smart City Technology, IoT, Data Analytics, Urban Planning',
                    'Funding: Rp 800 juta',
                    'Volunteers: 60 orang',
                    'Resources: IoT sensors, Data centers, Software platforms'
                ],
                'start_date' => now()->addDays(45),
                'end_date' => now()->addMonths(12),
                'location' => 'Semarang, Indonesia',
                'latitude' => -6.9667,
                'longitude' => 110.4167,
                'status' => 'planning',
                'min_ecosystems' => 4,
                'collaboration_terms' => 'Kolaborasi dengan pemerintah daerah dan sektor swasta.',
            ],

            // Health & Wellness
            [
                'title' => 'Telemedicine untuk Daerah Terpencil',
                'description' => 'Menyediakan akses layanan kesehatan berkualitas melalui teknologi telemedicine di daerah terpencil.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Menjangkau 50 desa terpencil, Melatih 100 tenaga kesehatan, Menyediakan 1000 konsultasi online',
                'required_resources' => [
                    'Expertise: Telemedicine, Healthcare, Technology, Medical Training',
                    'Funding: Rp 400 juta',
                    'Volunteers: 35 orang',
                    'Resources: Medical equipment, Internet infrastructure, Training materials'
                ],
                'start_date' => now()->addDays(20),
                'end_date' => now()->addMonths(8),
                'location' => 'Makassar, Indonesia',
                'latitude' => -5.1477,
                'longitude' => 119.4327,
                'status' => 'active',
                'min_ecosystems' => 3,
                'collaboration_terms' => 'Kerjasama dengan rumah sakit dan puskesmas lokal.',
            ],
            [
                'title' => 'Mental Health Awareness Campaign',
                'description' => 'Kampanye kesadaran kesehatan mental dan penyediaan layanan konseling untuk remaja dan dewasa muda.',
                'scale' => 'kecil',
                'scope' => 'local',
                'goals' => 'Menyelenggarakan 20 workshop mental health, Melatih 50 peer counselor, Menjangkau 2000 peserta',
                'required_resources' => [
                    'Expertise: Psychology, Mental Health, Counseling, Community Outreach',
                    'Funding: Rp 120 juta',
                    'Volunteers: 25 orang',
                    'Resources: Counseling materials, Workshop venues, Educational content'
                ],
                'start_date' => now()->addDays(12),
                'end_date' => now()->addMonths(4),
                'location' => 'Malang, Indonesia',
                'latitude' => -7.9797,
                'longitude' => 112.6304,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Fokus pada destigmatisasi dan aksesibilitas layanan kesehatan mental.',
            ],

            // Social Impact & Community Development
            [
                'title' => 'Aksi Kemanusiaan Bencana',
                'description' => 'Koordinasi bantuan kemanusiaan untuk daerah yang terkena bencana alam dengan fokus pada recovery dan resilience building.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Menyediakan bantuan untuk 5000 korban, Membangun 100 rumah tahan gempa, Melatih 200 relawan tanggap bencana',
                'required_resources' => [
                    'Expertise: Kemanusiaan, Konstruksi, Psikologi, Emergency Response',
                    'Funding: Rp 1 miliar',
                    'Volunteers: 100 orang',
                    'Resources: Bahan bangunan, Makanan, Obat-obatan, Emergency equipment'
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
            [
                'title' => 'Women Empowerment & Entrepreneurship',
                'description' => 'Program pemberdayaan perempuan melalui pelatihan kewirausahaan dan akses modal untuk usaha kecil.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Melatih 200 perempuan entrepreneur, Menyediakan 50 pinjaman modal, Membuat 100 usaha baru',
                'required_resources' => [
                    'Expertise: Entrepreneurship, Women Empowerment, Financial Management, Mentoring',
                    'Funding: Rp 300 juta',
                    'Volunteers: 30 orang',
                    'Resources: Training materials, Microfinance access, Mentoring network'
                ],
                'start_date' => now()->addDays(18),
                'end_date' => now()->addMonths(6),
                'location' => 'Palembang, Indonesia',
                'latitude' => -2.9909,
                'longitude' => 104.7565,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Fokus pada kesetaraan gender dan pemberdayaan ekonomi perempuan.',
            ],
            [
                'title' => 'Disability Inclusion Initiative',
                'description' => 'Meningkatkan inklusi dan aksesibilitas untuk penyandang disabilitas di berbagai aspek kehidupan.',
                'scale' => 'kecil',
                'scope' => 'local',
                'goals' => 'Melatih 100 caregiver, Membuat 20 fasilitas aksesibel, Menyediakan 50 alat bantu',
                'required_resources' => [
                    'Expertise: Disability Services, Accessibility Design, Occupational Therapy, Advocacy',
                    'Funding: Rp 180 juta',
                    'Volunteers: 20 orang',
                    'Resources: Assistive devices, Training materials, Accessibility tools'
                ],
                'start_date' => now()->addDays(14),
                'end_date' => now()->addMonths(5),
                'location' => 'Solo, Indonesia',
                'latitude' => -7.5755,
                'longitude' => 110.8243,
                'status' => 'active',
                'min_ecosystems' => 2,
                'collaboration_terms' => 'Melibatkan penyandang disabilitas dalam perencanaan dan implementasi.',
            ],

            // Arts & Culture
            [
                'title' => 'Digitalisasi Warisan Budaya',
                'description' => 'Mendokumentasikan dan melestarikan warisan budaya Indonesia melalui teknologi digital dan virtual reality.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Mendigitalkan 100 artefak budaya, Membuat 20 virtual museum, Melatih 50 digital curator',
                'required_resources' => [
                    'Expertise: Cultural Heritage, Digital Technology, 3D Modeling, Museum Curation',
                    'Funding: Rp 350 juta',
                    'Volunteers: 40 orang',
                    'Resources: 3D scanners, VR equipment, Digital storage, Museum partnerships'
                ],
                'start_date' => now()->addDays(30),
                'end_date' => now()->addMonths(10),
                'location' => 'Yogyakarta, Indonesia',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'status' => 'planning',
                'min_ecosystems' => 3,
                'collaboration_terms' => 'Kerjasama dengan museum dan komunitas budaya lokal.',
            ],

            // Research & Innovation
            [
                'title' => 'Open Source Research Platform',
                'description' => 'Membangun platform kolaboratif untuk penelitian open source yang dapat diakses oleh peneliti di seluruh Indonesia.',
                'scale' => 'besar',
                'scope' => 'national',
                'goals' => 'Membuat platform penelitian, Menghubungkan 500 peneliti, Menerbitkan 100 paper kolaboratif',
                'required_resources' => [
                    'Expertise: Research Management, Platform Development, Data Science, Academic Collaboration',
                    'Funding: Rp 600 juta',
                    'Volunteers: 45 orang',
                    'Resources: Cloud infrastructure, Research tools, Database systems'
                ],
                'start_date' => now()->addDays(40),
                'end_date' => now()->addMonths(15),
                'location' => 'Bogor, Indonesia',
                'latitude' => -6.5971,
                'longitude' => 106.8060,
                'status' => 'planning',
                'min_ecosystems' => 4,
                'collaboration_terms' => 'Open access dan peer review untuk semua penelitian.',
            ],
            [
                'title' => 'Sustainable Agriculture Research',
                'description' => 'Penelitian dan pengembangan pertanian berkelanjutan untuk meningkatkan produktivitas dan ketahanan pangan.',
                'scale' => 'sedang',
                'scope' => 'national',
                'goals' => 'Mengembangkan 10 varietas tahan iklim, Melatih 200 petani, Meningkatkan hasil panen 30%',
                'required_resources' => [
                    'Expertise: Agricultural Science, Climate Research, Plant Breeding, Farmer Training',
                    'Funding: Rp 400 juta',
                    'Volunteers: 35 orang',
                    'Resources: Research facilities, Seeds, Laboratory equipment, Field testing sites'
                ],
                'start_date' => now()->addDays(25),
                'end_date' => now()->addMonths(12),
                'location' => 'Lampung, Indonesia',
                'latitude' => -5.3971,
                'longitude' => 105.2668,
                'status' => 'active',
                'min_ecosystems' => 3,
                'collaboration_terms' => 'Kerjasama dengan universitas dan petani lokal.',
            ]
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
                'qr_code' => Str::random(6),
                'pasar_kolaboraya_id' => $pasarKolaboraya?->id,
            ]);

            // Invite ecosystems to participate (if any exist)
            if ($ecosystems->isNotEmpty()) {
                // Match ecosystems based on collective action theme
                $matchingEcosystems = $this->getMatchingEcosystems($collectiveAction, $ecosystems);
                $ecosystemsToInvite = $matchingEcosystems->random(min($actionData['min_ecosystems'] + 1, $matchingEcosystems->count()));
                
                foreach ($ecosystemsToInvite as $ecosystem) {
                    $invitationStatus = fake()->randomElement(['accepted', 'accepted', 'pending']); // 66% accepted
                    
                    CollectiveActionEcosystemInvitation::create([
                        'collective_action_id' => $collectiveAction->id,
                        'ecosystem_id' => $ecosystem->id,
                        'status' => $invitationStatus,
                        'invited_by' => $creator->id,
                    ]);

                    // Add ecosystem members to collective action if invitation is accepted
                    if ($invitationStatus === 'accepted') {
                        $collectiveAction->addEcosystemMembers($ecosystem, 'member');
                    }
                }
            }

            // Add creator as admin first (only if not already added through ecosystem)
            if (!$collectiveAction->isUserRegistered($creator)) {
                $collectiveAction->addUser($creator, 'admin', 'Action creator');
            }

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

    /**
     * Get ecosystems that match the collective action theme
     */
    private function getMatchingEcosystems($collectiveAction, $ecosystems)
    {
        $actionTitle = strtolower($collectiveAction->title);
        $actionDescription = strtolower($collectiveAction->description);
        
        // Define theme keywords for matching
        $themeKeywords = [
            'technology' => ['digital', 'tech', 'fintech', 'ai', 'smart', 'platform', 'software', 'app', 'online'],
            'education' => ['pendidikan', 'belajar', 'training', 'pelatihan', 'guru', 'siswa', 'vocational', 'skill'],
            'environment' => ['hijau', 'lingkungan', 'konservasi', 'marine', 'sustainable', 'climate', 'green', 'eco'],
            'health' => ['kesehatan', 'health', 'mental', 'telemedicine', 'medical', 'wellness', 'counseling'],
            'social' => ['sosial', 'community', 'empowerment', 'women', 'disability', 'inclusion', 'kemanusiaan'],
            'culture' => ['budaya', 'cultural', 'heritage', 'arts', 'museum', 'traditional'],
            'research' => ['research', 'riset', 'innovation', 'development', 'scientific', 'agriculture']
        ];
        
        $matchingEcosystems = collect();
        
        foreach ($ecosystems as $ecosystem) {
            $ecosystemTitle = strtolower($ecosystem->ecosystem_title);
            $ecosystemIssues = array_map('strtolower', $ecosystem->issues_addressed);
            $ecosystemDescription = strtolower($ecosystem->description);
            
            $matchScore = 0;
            
            // Check for theme matches
            foreach ($themeKeywords as $theme => $keywords) {
                $themeMatch = false;
                
                // Check action title and description
                foreach ($keywords as $keyword) {
                    if (strpos($actionTitle, $keyword) !== false || strpos($actionDescription, $keyword) !== false) {
                        $themeMatch = true;
                        break;
                    }
                }
                
                if ($themeMatch) {
                    // Check if ecosystem matches this theme
                    foreach ($keywords as $keyword) {
                        if (strpos($ecosystemTitle, $keyword) !== false || 
                            strpos($ecosystemDescription, $keyword) !== false ||
                            in_array($keyword, $ecosystemIssues)) {
                            $matchScore += 2;
                        }
                    }
                }
            }
            
            // Additional matching based on specific terms
            if (strpos($actionTitle, 'umkm') !== false && strpos($ecosystemTitle, 'tech') !== false) {
                $matchScore += 1;
            }
            
            if (strpos($actionTitle, 'bencana') !== false && (strpos($ecosystemTitle, 'social') !== false || strpos($ecosystemTitle, 'community') !== false)) {
                $matchScore += 1;
            }
            
            if (strpos($actionTitle, 'budaya') !== false && strpos($ecosystemTitle, 'cultural') !== false) {
                $matchScore += 1;
            }
            
            // If match score is positive, include this ecosystem
            if ($matchScore > 0) {
                $matchingEcosystems->push($ecosystem);
            }
        }
        
        // If no matches found, return random ecosystems
        if ($matchingEcosystems->isEmpty()) {
            return $ecosystems->random(min(3, $ecosystems->count()));
        }
        
        return $matchingEcosystems;
    }
}
