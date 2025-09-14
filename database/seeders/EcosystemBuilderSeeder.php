<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ecosystem;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EcosystemBuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if ecosystem builders already exist
        if (User::where('is_ecosystem_builder', true)->count() > 0) {
            $this->command->info('Ecosystem builders already exist. Skipping ecosystem builder creation.');
            return;
        }

        // Get super admin for approval
        $superAdmin = User::where('role', 'super_admin')->first();
        
        if (!$superAdmin) {
            $this->command->error('Super admin not found. Please run UserSeeder first.');
            return;
        }

        // Get some skills for the ecosystems
        $skills = Skill::all();
        $skillIds = $skills->pluck('id')->toArray();

        // Create ecosystem builder users with their ecosystems
        $ecosystemBuilders = [
            [
                'user' => [
                    'name' => 'Dr. Sarah Mitchell',
                    'email' => 'sarah.mitchell@ecosystem.com',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Experienced in sustainable development and community building with 10+ years of expertise.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Green Future Initiative',
                    'ecosystem_title' => 'Sustainable Community Development',
                    'issues_addressed' => [
                        'Climate Change Mitigation',
                        'Renewable Energy Adoption',
                        'Waste Reduction',
                        'Community Resilience'
                    ],
                    'work_region' => 'Southeast Asia',
                    'existing_roles' => array_slice($skillIds, 0, 5), // First 5 skills
                    'needed_roles' => array_slice($skillIds, 5, 8), // Next 8 skills
                    'max_users' => 50,
                    'terms_conditions' => 'Members must commit to sustainable practices and active participation in community initiatives.',
                    'description' => 'A collaborative ecosystem focused on building sustainable communities through innovative environmental solutions and community engagement.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Prof. Michael Chen',
                    'email' => 'michael.chen@tech-ecosystem.org',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Leading technology innovation expert with extensive experience in digital transformation and startup ecosystems.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => 1,
                ],
                'ecosystem' => [
                    'organization_name' => 'Tech Innovation Hub',
                    'ecosystem_title' => 'Digital Transformation & Innovation',
                    'issues_addressed' => [
                        'Digital Divide',
                        'Technology Education',
                        'Startup Support',
                        'Digital Literacy'
                    ],
                    'work_region' => 'Global',
                    'existing_roles' => array_slice($skillIds, 3, 6),
                    'needed_roles' => array_slice($skillIds, 9, 10),
                    'max_users' => 100,
                    'terms_conditions' => 'Members should have a passion for technology and innovation, with willingness to mentor others.',
                    'description' => 'An ecosystem dedicated to fostering technological innovation, supporting startups, and bridging the digital divide through education and collaboration.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Aisha Rahman',
                    'email' => 'aisha.rahman@health-ecosystem.net',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Public health specialist with expertise in community health programs and healthcare accessibility.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => 1,
                ],
                'ecosystem' => [
                    'organization_name' => 'Community Health Alliance',
                    'ecosystem_title' => 'Public Health & Wellness',
                    'issues_addressed' => [
                        'Healthcare Access',
                        'Mental Health Awareness',
                        'Preventive Care',
                        'Health Education'
                    ],
                    'work_region' => 'South Asia',
                    'existing_roles' => array_slice($skillIds, 6, 4),
                    'needed_roles' => array_slice($skillIds, 10, 6),
                    'max_users' => 75,
                    'terms_conditions' => 'Members must maintain professional standards and confidentiality in all health-related activities.',
                    'description' => 'A comprehensive health ecosystem focused on improving community health outcomes through education, prevention, and accessible healthcare services.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'James Rodriguez',
                    'email' => 'james.rodriguez@education-ecosystem.edu',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Educational technology leader with 15+ years in curriculum development and digital learning solutions.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => 1,
                ],
                'ecosystem' => [
                    'organization_name' => 'Future Learning Network',
                    'ecosystem_title' => 'Educational Innovation & Access',
                    'issues_addressed' => [
                        'Educational Inequality',
                        'Digital Learning Access',
                        'Teacher Training',
                        'Student Support'
                    ],
                    'work_region' => 'Latin America',
                    'existing_roles' => array_slice($skillIds, 2, 7),
                    'needed_roles' => array_slice($skillIds, 9, 9),
                    'max_users' => 60,
                    'terms_conditions' => 'Members should be committed to educational equity and continuous learning.',
                    'description' => 'An educational ecosystem dedicated to creating innovative learning solutions and ensuring equal access to quality education for all communities.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Elena Petrov',
                    'email' => 'elena.petrov@social-ecosystem.org',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Social impact specialist with expertise in community development and social entrepreneurship.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => 1,
                ],
                'ecosystem' => [
                    'organization_name' => 'Social Impact Collective',
                    'ecosystem_title' => 'Social Entrepreneurship & Community Development',
                    'issues_addressed' => [
                        'Poverty Alleviation',
                        'Social Entrepreneurship',
                        'Community Empowerment',
                        'Economic Development'
                    ],
                    'work_region' => 'Eastern Europe',
                    'existing_roles' => array_slice($skillIds, 1, 6),
                    'needed_roles' => array_slice($skillIds, 7, 8),
                    'max_users' => 40,
                    'terms_conditions' => 'Members must demonstrate commitment to social impact and community welfare.',
                    'description' => 'A collaborative ecosystem focused on fostering social entrepreneurship and community development through innovative solutions and sustainable practices.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Kenji Tanaka',
                    'email' => 'kenji.tanaka@research-ecosystem.jp',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Research and development expert with specialization in collaborative research and innovation management.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => 1,
                ],
                'ecosystem' => [
                    'organization_name' => 'Research Collaboration Network',
                    'ecosystem_title' => 'Scientific Research & Innovation',
                    'issues_addressed' => [
                        'Research Collaboration',
                        'Innovation Management',
                        'Knowledge Sharing',
                        'Scientific Communication'
                    ],
                    'work_region' => 'Asia-Pacific',
                    'existing_roles' => array_slice($skillIds, 4, 8),
                    'needed_roles' => array_slice($skillIds, 12, 6),
                    'max_users' => 80,
                    'terms_conditions' => 'Members must adhere to research ethics and contribute to knowledge sharing within the ecosystem.',
                    'description' => 'A research-focused ecosystem promoting scientific collaboration, innovation, and knowledge sharing across various disciplines and institutions.',
                    'is_active' => true,
                ]
            ]
        ];

        foreach ($ecosystemBuilders as $builderData) {
            // Create the ecosystem builder user
            $user = User::create($builderData['user']);

            // Create the ecosystem associated with this user
            $ecosystemData = $builderData['ecosystem'];
            $ecosystemData['creator_id'] = $user->id;
            
            $ecosystem = Ecosystem::create($ecosystemData);

            // Add the creator as an accepted member of their own ecosystem
            $ecosystem->users()->attach($user->id, [
                'status' => 'accepted',
                'join_reason' => 'Ecosystem Creator',
                'joined_at' => now(),
            ]);

            $this->command->info("Created ecosystem builder: {$user->name} with ecosystem: {$ecosystem->ecosystem_title}");
        }

        // Create some additional ecosystem builders with pending status
        $pendingBuilders = [
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@pending-ecosystem.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_ecosystem_builder' => true,
                'ecosystem_builder_status' => 'pending',
                'ecosystem_builder_reason' => 'New applicant with interest in environmental conservation and community engagement.',
            ],
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@pending-ecosystem.org',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_ecosystem_builder' => true,
                'ecosystem_builder_status' => 'pending',
                'ecosystem_builder_reason' => 'Technology entrepreneur seeking to build a startup ecosystem in the region.',
            ]
        ];

        foreach ($pendingBuilders as $builderData) {
            User::create($builderData);
            $this->command->info("Created pending ecosystem builder: {$builderData['name']}");
        }

        $this->command->info('Ecosystem Builder Seeder completed successfully!');
    }
}
