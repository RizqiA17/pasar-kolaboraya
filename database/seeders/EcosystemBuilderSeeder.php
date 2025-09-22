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
            $this->command->info('Ecosystem builders already exist. Checking if ecosystems need to be created...');
            
            // Check if we have active ecosystems
            if (Ecosystem::where('is_active', true)->count() > 0) {
                $this->command->info('Active ecosystems already exist. Skipping ecosystem creation.');
                return;
            }
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
            // Environmental & Sustainability Ecosystems
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
                    'existing_roles' => array_slice($skillIds, 0, 5),
                    'needed_roles' => array_slice($skillIds, 5, 8),
                    'max_users' => 50,
                    'terms_conditions' => 'Members must commit to sustainable practices and active participation in community initiatives.',
                    'description' => 'A collaborative ecosystem focused on building sustainable communities through innovative environmental solutions and community engagement.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.santoso@marine-conservation.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Marine biologist with 12+ years experience in coral reef conservation and sustainable fishing practices.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Marine Conservation Indonesia',
                    'ecosystem_title' => 'Ocean Conservation & Sustainable Fisheries',
                    'issues_addressed' => [
                        'Coral Reef Protection',
                        'Sustainable Fishing',
                        'Marine Pollution',
                        'Coastal Community Livelihoods'
                    ],
                    'work_region' => 'Indonesia',
                    'existing_roles' => array_slice($skillIds, 1, 6),
                    'needed_roles' => array_slice($skillIds, 7, 7),
                    'max_users' => 35,
                    'terms_conditions' => 'Members must be committed to marine conservation and work with local fishing communities.',
                    'description' => 'Dedicated to protecting Indonesia\'s marine biodiversity through community-based conservation and sustainable fishing practices.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Maya Sari',
                    'email' => 'maya.sari@urban-greening.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Urban planning expert specializing in green infrastructure and sustainable city development.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Urban Green Network',
                    'ecosystem_title' => 'Smart City & Urban Sustainability',
                    'issues_addressed' => [
                        'Urban Heat Island',
                        'Green Infrastructure',
                        'Smart Transportation',
                        'Air Quality Improvement'
                    ],
                    'work_region' => 'Jakarta Metropolitan Area',
                    'existing_roles' => array_slice($skillIds, 2, 8),
                    'needed_roles' => array_slice($skillIds, 10, 6),
                    'max_users' => 45,
                    'terms_conditions' => 'Members should have expertise in urban planning, technology, or environmental science.',
                    'description' => 'Creating sustainable and smart urban environments through innovative green infrastructure and technology solutions.',
                    'is_active' => true,
                ]
            ],

            // Technology & Innovation Ecosystems
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
                    'ecosystem_builder_approved_by' => $superAdmin->id,
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
                    'name' => 'Ahmad Rizki',
                    'email' => 'ahmad.rizki@fintech-innovation.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Fintech entrepreneur and blockchain expert with successful track record in digital financial services.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Fintech Innovation Lab',
                    'ecosystem_title' => 'Financial Technology & Digital Banking',
                    'issues_addressed' => [
                        'Financial Inclusion',
                        'Digital Banking',
                        'Cryptocurrency Education',
                        'Fintech Regulation'
                    ],
                    'work_region' => 'Indonesia',
                    'existing_roles' => array_slice($skillIds, 4, 7),
                    'needed_roles' => array_slice($skillIds, 11, 8),
                    'max_users' => 60,
                    'terms_conditions' => 'Members must have expertise in finance, technology, or regulatory compliance.',
                    'description' => 'Advancing financial inclusion and digital banking solutions through innovative fintech applications and regulatory guidance.',
                    'is_active' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Lisa Wang',
                    'email' => 'lisa.wang@ai-ecosystem.org',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'AI researcher and machine learning expert with focus on ethical AI development and implementation.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'AI for Good Collective',
                    'ecosystem_title' => 'Artificial Intelligence & Machine Learning',
                    'issues_addressed' => [
                        'Ethical AI Development',
                        'AI Education',
                        'Machine Learning Applications',
                        'Data Privacy & Security'
                    ],
                    'work_region' => 'Asia-Pacific',
                    'existing_roles' => array_slice($skillIds, 5, 9),
                    'needed_roles' => array_slice($skillIds, 14, 6),
                    'max_users' => 70,
                    'terms_conditions' => 'Members must adhere to ethical AI principles and contribute to responsible technology development.',
                    'description' => 'Promoting ethical AI development and machine learning applications that benefit society while ensuring privacy and security.',
                    'is_active' => true,
                ]
            ],

            // Health & Wellness Ecosystems
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
                    'ecosystem_builder_approved_by' => $superAdmin->id,
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
                    'name' => 'Dr. Siti Nurhaliza',
                    'email' => 'siti.nurhaliza@mental-health.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Clinical psychologist specializing in community mental health and trauma-informed care.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Mental Health Indonesia',
                    'ecosystem_title' => 'Mental Health & Psychological Support',
                    'issues_addressed' => [
                        'Mental Health Stigma',
                        'Trauma Recovery',
                        'Youth Mental Health',
                        'Crisis Intervention'
                    ],
                    'work_region' => 'Indonesia',
                    'existing_roles' => array_slice($skillIds, 7, 5),
                    'needed_roles' => array_slice($skillIds, 12, 7),
                    'max_users' => 40,
                    'terms_conditions' => 'Members must have professional qualifications in mental health or related fields.',
                    'description' => 'Breaking down mental health stigma and providing accessible psychological support services across Indonesia.',
                    'is_active' => true,
                ]
            ],

            // Education & Learning Ecosystems
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
                    'ecosystem_builder_approved_by' => $superAdmin->id,
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
                    'name' => 'Prof. Dewi Kartika',
                    'email' => 'dewi.kartika@vocational-training.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Vocational education expert with focus on skill development and job placement programs.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Skills Development Center',
                    'ecosystem_title' => 'Vocational Training & Skill Development',
                    'issues_addressed' => [
                        'Skills Gap',
                        'Youth Unemployment',
                        'Industry Training',
                        'Job Placement'
                    ],
                    'work_region' => 'West Java, Indonesia',
                    'existing_roles' => array_slice($skillIds, 8, 6),
                    'needed_roles' => array_slice($skillIds, 14, 8),
                    'max_users' => 55,
                    'terms_conditions' => 'Members must have industry experience or educational background in vocational training.',
                    'description' => 'Bridging the skills gap through comprehensive vocational training programs and industry partnerships.',
                    'is_active' => true,
                ]
            ],

            // Social Impact & Community Development
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
                    'ecosystem_builder_approved_by' => $superAdmin->id,
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
                    'name' => 'Ibu Fatimah',
                    'email' => 'ibu.fatimah@women-empowerment.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Women\'s rights advocate and microfinance expert with 20+ years in community development.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Women Empowerment Network',
                    'ecosystem_title' => 'Gender Equality & Women\'s Empowerment',
                    'issues_addressed' => [
                        'Gender Equality',
                        'Women\'s Economic Empowerment',
                        'Gender-Based Violence Prevention',
                        'Leadership Development'
                    ],
                    'work_region' => 'Indonesia',
                    'existing_roles' => array_slice($skillIds, 9, 5),
                    'needed_roles' => array_slice($skillIds, 14, 6),
                    'max_users' => 30,
                    'terms_conditions' => 'Members must be committed to gender equality and women\'s empowerment principles.',
                    'description' => 'Empowering women through economic opportunities, leadership development, and advocacy for gender equality.',
                    'is_active' => true,
                ]
            ],

            // Research & Innovation
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
                    'ecosystem_builder_approved_by' => $superAdmin->id,
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
            ],
            [
                'user' => [
                    'name' => 'Dr. Agus Prasetyo',
                    'email' => 'agus.prasetyo@agriculture-research.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Agricultural scientist specializing in sustainable farming and food security research.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Agricultural Innovation Lab',
                    'ecosystem_title' => 'Sustainable Agriculture & Food Security',
                    'issues_addressed' => [
                        'Food Security',
                        'Sustainable Farming',
                        'Climate-Resilient Crops',
                        'Rural Development'
                    ],
                    'work_region' => 'Southeast Asia',
                    'existing_roles' => array_slice($skillIds, 6, 7),
                    'needed_roles' => array_slice($skillIds, 13, 7),
                    'max_users' => 65,
                    'terms_conditions' => 'Members must have expertise in agriculture, food science, or related fields.',
                    'description' => 'Advancing sustainable agriculture and food security through research, innovation, and farmer education.',
                    'is_active' => true,
                ]
            ],

            // Arts & Culture
            [
                'user' => [
                    'name' => 'Bambang Sutrisno',
                    'email' => 'bambang.sutrisno@cultural-heritage.id',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_ecosystem_builder' => true,
                    'ecosystem_builder_status' => 'approved',
                    'ecosystem_builder_reason' => 'Cultural preservation expert and traditional arts advocate with extensive museum and heritage experience.',
                    'ecosystem_builder_approved_at' => now(),
                    'ecosystem_builder_approved_by' => $superAdmin->id,
                ],
                'ecosystem' => [
                    'organization_name' => 'Cultural Heritage Foundation',
                    'ecosystem_title' => 'Cultural Preservation & Arts',
                    'issues_addressed' => [
                        'Cultural Heritage Preservation',
                        'Traditional Arts Revival',
                        'Cultural Education',
                        'Tourism Development'
                    ],
                    'work_region' => 'Indonesia',
                    'existing_roles' => array_slice($skillIds, 10, 4),
                    'needed_roles' => array_slice($skillIds, 14, 6),
                    'max_users' => 25,
                    'terms_conditions' => 'Members must be passionate about cultural preservation and have relevant expertise.',
                    'description' => 'Preserving Indonesia\'s rich cultural heritage through education, documentation, and community engagement.',
                    'is_active' => true,
                ]
            ]
        ];

        // Get the first active Pasar Kolaboraya for ecosystem assignment
        $pasarKolaboraya = \App\Models\PasarKolaboraya::where('status', 'active')->first();

        foreach ($ecosystemBuilders as $builderData) {
            // Create the ecosystem builder user
            $user = User::create($builderData['user']);

            // Create the ecosystem associated with this user
            $ecosystemData = $builderData['ecosystem'];
            $ecosystemData['creator_id'] = $user->id;
            $ecosystemData['pasar_kolaboraya_id'] = $pasarKolaboraya?->id;
            $ecosystemData['qr_code'] = \Str::random(6);
            
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
