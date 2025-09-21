<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ecosystem;
use App\Models\PasarKolaboraya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EcosystemMappingTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating comprehensive test data for ecosystem mapping feature...');

        // Get or create active Pasar Kolaboraya
        $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        if (!$pasarKolaboraya) {
            $pasarKolaboraya = PasarKolaboraya::create([
                'name' => 'Pasar Kolaboraya Test 2025',
                'description' => 'Test environment for ecosystem mapping visualization',
                'created_by' => 1,
                'status' => 'active',
                'settings' => [
                    'allow_ecosystem_creation' => true,
                    'allow_collective_actions' => true,
                    'auto_approve_joins' => true,
                    'max_ecosystems_per_user' => 5,
                ],
                'started_at' => now(),
            ]);
        }

        // Create diverse test users with specific roles
        $testUsers = $this->createTestUsers();
        
        // Create comprehensive ecosystems with realistic data
        $ecosystems = $this->createTestEcosystems($pasarKolaboraya, $testUsers);
        
        // Assign users to ecosystems with specific roles
        $this->assignUsersToEcosystems($ecosystems, $testUsers);

        $this->command->info('Ecosystem mapping test data created successfully!');
        $this->command->info("Created {$testUsers->count()} users and {$ecosystems->count()} ecosystems");
    }

    private function createTestUsers()
    {
        $users = collect();

        // Technology & Innovation Users
        $techUsers = [
            ['name' => 'Alex Chen', 'email' => 'alex.chen@tech.com', 'role' => 'Software Developer', 'user_type' => 'partisipan'],
            ['name' => 'Sarah Kim', 'email' => 'sarah.kim@tech.com', 'role' => 'Product Manager', 'user_type' => 'partisipan'],
            ['name' => 'David Rodriguez', 'email' => 'david.rodriguez@tech.com', 'role' => 'UI/UX Designer', 'user_type' => 'partisipan'],
            ['name' => 'Lisa Wang', 'email' => 'lisa.wang@tech.com', 'role' => 'Data Scientist', 'user_type' => 'partisipan'],
            ['name' => 'Mike Johnson', 'email' => 'mike.johnson@tech.com', 'role' => 'DevOps Engineer', 'user_type' => 'partisipan'],
            ['name' => 'Emma Davis', 'email' => 'emma.davis@tech.com', 'role' => 'QA Tester', 'user_type' => 'partisipan'],
        ];

        // Environmental & Sustainability Users
        $envUsers = [
            ['name' => 'Dr. Green Earth', 'email' => 'green.earth@env.com', 'role' => 'Environmental Scientist', 'user_type' => 'partisipan'],
            ['name' => 'Maria Santos', 'email' => 'maria.santos@env.com', 'role' => 'Sustainability Consultant', 'user_type' => 'partisipan'],
            ['name' => 'James Wilson', 'email' => 'james.wilson@env.com', 'role' => 'Renewable Energy Expert', 'user_type' => 'partisipan'],
            ['name' => 'Anna Petrov', 'email' => 'anna.petrov@env.com', 'role' => 'Climate Researcher', 'user_type' => 'partisipan'],
            ['name' => 'Tom Brown', 'email' => 'tom.brown@env.com', 'role' => 'Eco Activist', 'user_type' => 'partisipan'],
        ];

        // Health & Wellness Users
        $healthUsers = [
            ['name' => 'Dr. Sarah Mitchell', 'email' => 'sarah.mitchell@health.com', 'role' => 'Public Health Specialist', 'user_type' => 'partisipan'],
            ['name' => 'Dr. Ahmed Hassan', 'email' => 'ahmed.hassan@health.com', 'role' => 'Mental Health Counselor', 'user_type' => 'partisipan'],
            ['name' => 'Nurse Jennifer', 'email' => 'jennifer.nurse@health.com', 'role' => 'Community Health Nurse', 'user_type' => 'partisipan'],
            ['name' => 'Dr. Carlos Mendez', 'email' => 'carlos.mendez@health.com', 'role' => 'Epidemiologist', 'user_type' => 'partisipan'],
        ];

        // Education & Learning Users
        $eduUsers = [
            ['name' => 'Prof. Michael Chen', 'email' => 'michael.chen@edu.com', 'role' => 'Educational Technologist', 'user_type' => 'partisipan'],
            ['name' => 'Dr. Elena Rodriguez', 'email' => 'elena.rodriguez@edu.com', 'role' => 'Curriculum Developer', 'user_type' => 'partisipan'],
            ['name' => 'Teacher Maria', 'email' => 'maria.teacher@edu.com', 'role' => 'Online Instructor', 'user_type' => 'partisipan'],
            ['name' => 'Dr. Kenji Tanaka', 'email' => 'kenji.tanaka@edu.com', 'role' => 'Learning Designer', 'user_type' => 'partisipan'],
        ];

        // Social Impact Users
        $socialUsers = [
            ['name' => 'Aisha Rahman', 'email' => 'aisha.rahman@social.com', 'role' => 'Social Worker', 'user_type' => 'partisipan'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@social.com', 'role' => 'Community Organizer', 'user_type' => 'partisipan'],
            ['name' => 'Fatima Al-Zahra', 'email' => 'fatima.alzahra@social.com', 'role' => 'Youth Advocate', 'user_type' => 'partisipan'],
            ['name' => 'John Smith', 'email' => 'john.smith@social.com', 'role' => 'Policy Analyst', 'user_type' => 'partisipan'],
        ];

        // Arts & Culture Users
        $artsUsers = [
            ['name' => 'Bambang Sutrisno', 'email' => 'bambang.sutrisno@arts.com', 'role' => 'Cultural Preservationist', 'user_type' => 'partisipan'],
            ['name' => 'Isabella Martinez', 'email' => 'isabella.martinez@arts.com', 'role' => 'Art Curator', 'user_type' => 'partisipan'],
            ['name' => 'Yuki Nakamura', 'email' => 'yuki.nakamura@arts.com', 'role' => 'Digital Artist', 'user_type' => 'partisipan'],
        ];

        // Business & Finance Users
        $businessUsers = [
            ['name' => 'Robert Kim', 'email' => 'robert.kim@business.com', 'role' => 'Business Analyst', 'user_type' => 'partisipan'],
            ['name' => 'Sophie Anderson', 'email' => 'sophie.anderson@business.com', 'role' => 'Financial Advisor', 'user_type' => 'partisipan'],
            ['name' => 'Hassan Ali', 'email' => 'hassan.ali@business.com', 'role' => 'Investment Manager', 'user_type' => 'partisipan'],
        ];

        $allUsers = array_merge($techUsers, $envUsers, $healthUsers, $eduUsers, $socialUsers, $artsUsers, $businessUsers);

        foreach ($allUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password123'),
                'role' => 'user',
                'assigned_role' => $userData['role'],
                'user_type' => $userData['user_type'],
                'is_ecosystem_builder' => false,
                'email_verified_at' => now(),
            ]);
            $users->push($user);
        }

        return $users;
    }

    private function createTestEcosystems($pasarKolaboraya, $users)
    {
        $ecosystems = collect();

        // Technology Innovation Ecosystem
        $techEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'alex.chen@tech.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Tech Innovation Hub',
            'ecosystem_title' => 'Digital Transformation & Innovation',
            'issues_addressed' => [
                'Digital Divide',
                'Technology Education',
                'Startup Support',
                'Digital Literacy',
                'Cybersecurity'
            ],
            'work_region' => 'Global',
            'existing_roles' => [
                'Software Developer',
                'Product Manager',
                'UI/UX Designer',
                'Data Scientist',
                'DevOps Engineer'
            ],
            'needed_roles' => [
                'QA Tester',
                'System Architect',
                'Security Specialist',
                'Technical Writer',
                'Project Coordinator'
            ],
            'max_users' => 50,
            'terms_conditions' => 'Members must have technical expertise and commitment to innovation.',
            'description' => 'A collaborative ecosystem focused on digital transformation and technological innovation.',
            'is_active' => true,
        ]);
        $ecosystems->push($techEcosystem);

        // Environmental Sustainability Ecosystem
        $envEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'green.earth@env.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Green Future Initiative',
            'ecosystem_title' => 'Sustainable Community Development',
            'issues_addressed' => [
                'Climate Change Mitigation',
                'Renewable Energy Adoption',
                'Waste Reduction',
                'Community Resilience',
                'Biodiversity Conservation'
            ],
            'work_region' => 'Southeast Asia',
            'existing_roles' => [
                'Environmental Scientist',
                'Sustainability Consultant',
                'Renewable Energy Expert',
                'Climate Researcher'
            ],
            'needed_roles' => [
                'Eco Activist',
                'Policy Maker',
                'Community Educator',
                'Green Technology Developer'
            ],
            'max_users' => 40,
            'terms_conditions' => 'Members must commit to sustainable practices and environmental protection.',
            'description' => 'Building sustainable communities through environmental innovation and community engagement.',
            'is_active' => true,
        ]);
        $ecosystems->push($envEcosystem);

        // Health & Wellness Ecosystem
        $healthEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'sarah.mitchell@health.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Community Health Alliance',
            'ecosystem_title' => 'Public Health & Wellness',
            'issues_addressed' => [
                'Healthcare Access',
                'Mental Health Awareness',
                'Preventive Care',
                'Health Education',
                'Disease Prevention'
            ],
            'work_region' => 'South Asia',
            'existing_roles' => [
                'Public Health Specialist',
                'Mental Health Counselor',
                'Community Health Nurse',
                'Epidemiologist'
            ],
            'needed_roles' => [
                'Health Educator',
                'Medical Researcher',
                'Health Policy Analyst',
                'Community Outreach Coordinator'
            ],
            'max_users' => 35,
            'terms_conditions' => 'Members must maintain professional standards and confidentiality.',
            'description' => 'Improving community health outcomes through education and accessible healthcare.',
            'is_active' => true,
        ]);
        $ecosystems->push($healthEcosystem);

        // Education Innovation Ecosystem
        $eduEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'michael.chen@edu.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Future Learning Network',
            'ecosystem_title' => 'Educational Innovation & Access',
            'issues_addressed' => [
                'Educational Inequality',
                'Digital Learning Access',
                'Teacher Training',
                'Student Support',
                'Curriculum Development'
            ],
            'work_region' => 'Asia-Pacific',
            'existing_roles' => [
                'Educational Technologist',
                'Curriculum Developer',
                'Online Instructor',
                'Learning Designer'
            ],
            'needed_roles' => [
                'Educational Researcher',
                'Student Counselor',
                'Technology Trainer',
                'Assessment Specialist'
            ],
            'max_users' => 45,
            'terms_conditions' => 'Members should be committed to educational equity and continuous learning.',
            'description' => 'Creating innovative learning solutions and ensuring equal access to quality education.',
            'is_active' => true,
        ]);
        $ecosystems->push($eduEcosystem);

        // Social Impact Ecosystem
        $socialEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'aisha.rahman@social.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Social Impact Collective',
            'ecosystem_title' => 'Social Entrepreneurship & Community Development',
            'issues_addressed' => [
                'Poverty Alleviation',
                'Social Entrepreneurship',
                'Community Empowerment',
                'Economic Development',
                'Social Justice'
            ],
            'work_region' => 'Global',
            'existing_roles' => [
                'Social Worker',
                'Community Organizer',
                'Youth Advocate',
                'Policy Analyst'
            ],
            'needed_roles' => [
                'Grant Writer',
                'Program Manager',
                'Community Researcher',
                'Advocacy Specialist'
            ],
            'max_users' => 30,
            'terms_conditions' => 'Members must demonstrate commitment to social impact and community welfare.',
            'description' => 'Fostering social entrepreneurship and community development through innovative solutions.',
            'is_active' => true,
        ]);
        $ecosystems->push($socialEcosystem);

        // Arts & Culture Ecosystem
        $artsEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'bambang.sutrisno@arts.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Cultural Heritage Foundation',
            'ecosystem_title' => 'Cultural Preservation & Arts',
            'issues_addressed' => [
                'Cultural Heritage Preservation',
                'Traditional Arts Revival',
                'Cultural Education',
                'Tourism Development',
                'Digital Archiving'
            ],
            'work_region' => 'Indonesia',
            'existing_roles' => [
                'Cultural Preservationist',
                'Art Curator',
                'Digital Artist'
            ],
            'needed_roles' => [
                'Museum Curator',
                'Cultural Educator',
                'Tourism Guide',
                'Digital Archivist'
            ],
            'max_users' => 25,
            'terms_conditions' => 'Members must be passionate about cultural preservation and have relevant expertise.',
            'description' => 'Preserving cultural heritage through education, documentation, and community engagement.',
            'is_active' => true,
        ]);
        $ecosystems->push($artsEcosystem);

        // Business & Finance Ecosystem
        $businessEcosystem = Ecosystem::create([
            'creator_id' => $users->where('email', 'robert.kim@business.com')->first()->id,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'organization_name' => 'Business Innovation Lab',
            'ecosystem_title' => 'Entrepreneurship & Financial Innovation',
            'issues_addressed' => [
                'Financial Inclusion',
                'Startup Funding',
                'Business Development',
                'Market Research',
                'Investment Opportunities'
            ],
            'work_region' => 'Asia-Pacific',
            'existing_roles' => [
                'Business Analyst',
                'Financial Advisor',
                'Investment Manager'
            ],
            'needed_roles' => [
                'Startup Mentor',
                'Market Researcher',
                'Financial Planner',
                'Business Consultant'
            ],
            'max_users' => 40,
            'terms_conditions' => 'Members must have business or financial expertise and ethical standards.',
            'description' => 'Supporting entrepreneurship and financial innovation through mentorship and resources.',
            'is_active' => true,
        ]);
        $ecosystems->push($businessEcosystem);

        return $ecosystems;
    }

    private function assignUsersToEcosystems($ecosystems, $users)
    {
        // Technology Ecosystem assignments
        $techEcosystem = $ecosystems->where('ecosystem_title', 'Digital Transformation & Innovation')->first();
        $techUsers = $users->whereIn('email', [
            'alex.chen@tech.com',
            'sarah.kim@tech.com',
            'david.rodriguez@tech.com',
            'lisa.wang@tech.com',
            'mike.johnson@tech.com',
            'emma.davis@tech.com'
        ]);
        
        foreach ($techUsers as $user) {
            $techEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Technical expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // Environmental Ecosystem assignments
        $envEcosystem = $ecosystems->where('ecosystem_title', 'Sustainable Community Development')->first();
        $envUsers = $users->whereIn('email', [
            'green.earth@env.com',
            'maria.santos@env.com',
            'james.wilson@env.com',
            'anna.petrov@env.com',
            'tom.brown@env.com'
        ]);
        
        foreach ($envUsers as $user) {
            $envEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Environmental expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 45)),
            ]);
        }

        // Health Ecosystem assignments
        $healthEcosystem = $ecosystems->where('ecosystem_title', 'Public Health & Wellness')->first();
        $healthUsers = $users->whereIn('email', [
            'sarah.mitchell@health.com',
            'ahmed.hassan@health.com',
            'jennifer.nurse@health.com',
            'carlos.mendez@health.com'
        ]);
        
        foreach ($healthUsers as $user) {
            $healthEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Health expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 60)),
            ]);
        }

        // Education Ecosystem assignments
        $eduEcosystem = $ecosystems->where('ecosystem_title', 'Educational Innovation & Access')->first();
        $eduUsers = $users->whereIn('email', [
            'michael.chen@edu.com',
            'elena.rodriguez@edu.com',
            'maria.teacher@edu.com',
            'kenji.tanaka@edu.com'
        ]);
        
        foreach ($eduUsers as $user) {
            $eduEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Educational expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 40)),
            ]);
        }

        // Social Impact Ecosystem assignments
        $socialEcosystem = $ecosystems->where('ecosystem_title', 'Social Entrepreneurship & Community Development')->first();
        $socialUsers = $users->whereIn('email', [
            'aisha.rahman@social.com',
            'budi.santoso@social.com',
            'fatima.alzahra@social.com',
            'john.smith@social.com'
        ]);
        
        foreach ($socialUsers as $user) {
            $socialEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Social impact expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 50)),
            ]);
        }

        // Arts & Culture Ecosystem assignments
        $artsEcosystem = $ecosystems->where('ecosystem_title', 'Cultural Preservation & Arts')->first();
        $artsUsers = $users->whereIn('email', [
            'bambang.sutrisno@arts.com',
            'isabella.martinez@arts.com',
            'yuki.nakamura@arts.com'
        ]);
        
        foreach ($artsUsers as $user) {
            $artsEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Cultural expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 35)),
            ]);
        }

        // Business Ecosystem assignments
        $businessEcosystem = $ecosystems->where('ecosystem_title', 'Entrepreneurship & Financial Innovation')->first();
        $businessUsers = $users->whereIn('email', [
            'robert.kim@business.com',
            'sophie.anderson@business.com',
            'hassan.ali@business.com'
        ]);
        
        foreach ($businessUsers as $user) {
            $businessEcosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Business expertise in ' . $user->assigned_role,
                'joined_at' => now()->subDays(rand(1, 25)),
            ]);
        }

        // Add some cross-ecosystem memberships for more interesting visualization
        $this->addCrossEcosystemMemberships($ecosystems, $users);
    }

    private function addCrossEcosystemMemberships($ecosystems, $users)
    {
        // Some users belong to multiple ecosystems
        $crossMemberships = [
            'alex.chen@tech.com' => ['Digital Transformation & Innovation', 'Educational Innovation & Access'],
            'sarah.kim@tech.com' => ['Digital Transformation & Innovation', 'Social Entrepreneurship & Community Development'],
            'green.earth@env.com' => ['Sustainable Community Development', 'Social Entrepreneurship & Community Development'],
            'michael.chen@edu.com' => ['Educational Innovation & Access', 'Digital Transformation & Innovation'],
            'aisha.rahman@social.com' => ['Social Entrepreneurship & Community Development', 'Public Health & Wellness'],
        ];

        foreach ($crossMemberships as $email => $ecosystemTitles) {
            $user = $users->where('email', $email)->first();
            if ($user) {
                foreach ($ecosystemTitles as $title) {
                    $ecosystem = $ecosystems->where('ecosystem_title', $title)->first();
                    if ($ecosystem && !$ecosystem->users()->where('user_id', $user->id)->exists()) {
                        $ecosystem->users()->attach($user->id, [
                            'status' => 'accepted',
                            'join_reason' => 'Cross-domain expertise in ' . $user->assigned_role,
                            'joined_at' => now()->subDays(rand(1, 20)),
                        ]);
                    }
                }
            }
        }
    }
}
