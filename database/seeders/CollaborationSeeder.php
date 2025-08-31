<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collaboration;
use App\Models\CollaborationUser;
use Illuminate\Database\Seeder;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() < 3) {
            throw new \Exception('Need at least 3 users to create collaborations');
        }

        // Create test collaborations for different scenarios
        $this->createTestCollaborations($users);
        
        // Create additional random collaborations
        $this->createRandomCollaborations($users);
        
        // Create collaboration invitations for testing
        $this->createCollaborationInvitations($users);
    }

    /**
     * Create test collaborations for specific testing scenarios
     */
    private function createTestCollaborations($users): void
    {
        // Test Collaboration 1: Pending with many members
        $collab1 = Collaboration::create([
            'title' => 'Project A - Kolaborasi Pending Test',
            'description' => 'Kolaborasi ini dibuat untuk testing fitur pending. Tidak bisa menambah todo atau mengubah status todo.',
            'status' => 'pending',
            'created_by' => $users->first()->id,
        ]);

        $this->addMembersToCollaboration($collab1, $users->take(5), 'accepted');

        // Test Collaboration 2: Active with mixed todo statuses
        $collab2 = Collaboration::create([
            'title' => 'Project B - Kolaborasi Active Test',
            'description' => 'Kolaborasi ini dibuat untuk testing fitur active. Bisa menambah todo dan mengubah status todo.',
            'status' => 'active',
            'created_by' => $users->skip(1)->first()->id,
        ]);

        $this->addMembersToCollaboration($collab2, $users->take(4), 'accepted');

        // Test Collaboration 3: Completed with mostly completed todos
        $collab3 = Collaboration::create([
            'title' => 'Project C - Kolaborasi Completed Test',
            'description' => 'Kolaborasi ini dibuat untuk testing fitur completed. Semua todo sudah selesai.',
            'status' => 'completed',
            'created_by' => $users->skip(2)->first()->id,
        ]);

        $this->addMembersToCollaboration($collab3, $users->take(3), 'accepted');
    }

    /**
     * Create additional random collaborations for variety
     */
    private function createRandomCollaborations($users): void
    {
        $collaborations = [
            [
                'title' => 'Pengembangan Aplikasi Mobile E-Commerce',
                'description' => 'Kolaborasi untuk membuat aplikasi mobile e-commerce yang user-friendly dengan fitur pembayaran terintegrasi.',
                'status' => 'pending',
                'members_count' => 3
            ],
            [
                'title' => 'Desain Website Portfolio Kreatif',
                'description' => 'Membuat website portfolio yang menarik dan responsif untuk showcase karya-karya kreatif.',
                'status' => 'pending',
                'members_count' => 2
            ],
            [
                'title' => 'Sistem Manajemen Inventori Digital',
                'description' => 'Mengembangkan sistem manajemen inventori yang efisien dengan tracking real-time dan laporan otomatis.',
                'status' => 'active',
                'members_count' => 4
            ],
            [
                'title' => 'Platform Belajar Online Interaktif',
                'description' => 'Membuat platform pembelajaran online dengan fitur video conference, quiz, dan progress tracking.',
                'status' => 'active',
                'members_count' => 5
            ],
            [
                'title' => 'Aplikasi Fitness Tracking Personal',
                'description' => 'Aplikasi untuk tracking aktivitas fitness dengan analisis data dan rekomendasi personal.',
                'status' => 'active',
                'members_count' => 3
            ],
            [
                'title' => 'Sistem Booking Hotel Online',
                'description' => 'Platform booking hotel dengan fitur pencarian, filter, dan pembayaran online yang aman.',
                'status' => 'completed',
                'members_count' => 4
            ],
            [
                'title' => 'Aplikasi Delivery Food & Beverages',
                'description' => 'Sistem delivery makanan dan minuman dengan tracking real-time dan rating system.',
                'status' => 'completed',
                'members_count' => 3
            ],
            [
                'title' => 'Website Company Profile Modern',
                'description' => 'Website company profile dengan desain modern, responsif, dan SEO optimized.',
                'status' => 'completed',
                'members_count' => 2
            ]
        ];

        foreach($collaborations as $collabData) {
            $collaboration = Collaboration::create([
                'title' => $collabData['title'],
                'description' => $collabData['description'],
                'status' => $collabData['status'],
                'created_by' => $users->random()->id,
            ]);

            $this->addMembersToCollaboration($collaboration, $users->random($collabData['members_count']), 'accepted');
        }
    }

    /**
     * Create collaboration invitations for testing pending workflow
     */
    private function createCollaborationInvitations($users): void
    {
        // Create a collaboration with pending invitations
        $invitationCollab = Collaboration::create([
            'title' => 'Project D - Kolaborasi dengan Undangan Pending',
            'description' => 'Kolaborasi ini memiliki beberapa undangan yang masih pending untuk testing fitur invitation.',
            'status' => 'pending',
            'created_by' => $users->last()->id,
        ]);

        // Add creator as accepted member
        CollaborationUser::create([
            'collaboration_id' => $invitationCollab->id,
            'user_id' => $invitationCollab->created_by,
            'status' => 'accepted'
        ]);

        // Add some users with pending status
        $pendingUsers = $users->take(3)->where('id', '!=', $invitationCollab->created_by);
        foreach ($pendingUsers as $user) {
            CollaborationUser::create([
                'collaboration_id' => $invitationCollab->id,
                'user_id' => $user->id,
                'status' => 'pending'
            ]);
        }

        // Add some users with declined status
        $declinedUsers = $users->skip(3)->take(2)->where('id', '!=', $invitationCollab->created_by);
        foreach ($declinedUsers as $user) {
            CollaborationUser::create([
                'collaboration_id' => $invitationCollab->id,
                'user_id' => $user->id,
                'status' => 'declined'
            ]);
        }
    }

    /**
     * Add members to a collaboration with specified status
     */
    private function addMembersToCollaboration($collaboration, $members, $status): void
    {
        // Add creator as accepted member if not already added
        if (!$collaboration->collaborationUsers()->where('user_id', $collaboration->created_by)->exists()) {
            CollaborationUser::create([
                'collaboration_id' => $collaboration->id,
                'user_id' => $collaboration->created_by,
                'status' => 'accepted'
            ]);
        }

        // Add additional members
        foreach ($members as $member) {
            if ($member->id !== $collaboration->created_by) {
                CollaborationUser::create([
                    'collaboration_id' => $collaboration->id,
                    'user_id' => $member->id,
                    'status' => $status
                ]);
            }
        }
    }
}
