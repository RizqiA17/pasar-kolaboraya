<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collaborations = Collaboration::all();
        
        foreach ($collaborations as $collaboration) {
            // Only create todos for active and completed collaborations
            if ($collaboration->status === 'pending') {
                continue; // Skip pending collaborations
            }

            // Create realistic todos based on collaboration type
            $todos = $this->getTodosForCollaboration($collaboration);
            
            foreach($todos as $todoData) {
                Todo::create([
                    'collaboration_id' => $collaboration->id,
                    'title' => $todoData['title'],
                    'description' => $todoData['description'],
                    'status' => $todoData['status'],
                    'created_by' => $collaboration->collaborationUsers->random()->user_id,
                ]);
            }
        }
    }

    /**
     * Get appropriate todos based on collaboration type and status
     */
    private function getTodosForCollaboration($collaboration): array
    {
        // Special test collaborations
        if (str_contains($collaboration->title, 'Test')) {
            return $this->getTestTodos($collaboration);
        }

        $baseTodos = [
            'Pengembangan Aplikasi Mobile E-Commerce' => [
                ['title' => 'Analisis kebutuhan user', 'description' => 'Mengumpulkan dan menganalisis kebutuhan pengguna aplikasi', 'status' => 'completed'],
                ['title' => 'Design UI/UX mockup', 'description' => 'Membuat mockup interface pengguna yang menarik', 'status' => 'completed'],
                ['title' => 'Implementasi backend API', 'description' => 'Mengembangkan API backend untuk aplikasi mobile', 'status' => 'active'],
                ['title' => 'Testing aplikasi mobile', 'description' => 'Melakukan testing pada berbagai device dan OS', 'status' => 'pending'],
                ['title' => 'Deployment ke app store', 'description' => 'Publish aplikasi ke Google Play Store dan App Store', 'status' => 'pending']
            ],
            'Sistem Manajemen Inventori Digital' => [
                ['title' => 'Database design', 'description' => 'Merancang struktur database untuk sistem inventori', 'status' => 'completed'],
                ['title' => 'User authentication system', 'description' => 'Implementasi sistem login dan role management', 'status' => 'completed'],
                ['title' => 'CRUD operations', 'description' => 'Membuat operasi create, read, update, delete', 'status' => 'active'],
                ['title' => 'Reporting dashboard', 'description' => 'Membuat dashboard untuk laporan inventori', 'status' => 'pending'],
                ['title' => 'Integration testing', 'description' => 'Testing integrasi antar modul sistem', 'status' => 'pending']
            ],
            'Platform Belajar Online Interaktif' => [
                ['title' => 'Video streaming setup', 'description' => 'Setup sistem streaming video untuk pembelajaran', 'status' => 'completed'],
                ['title' => 'Quiz system development', 'description' => 'Mengembangkan sistem quiz dan assessment', 'status' => 'active'],
                ['title' => 'Progress tracking', 'description' => 'Implementasi sistem tracking progress belajar', 'status' => 'active'],
                ['title' => 'Mobile app development', 'description' => 'Membuat aplikasi mobile untuk platform', 'status' => 'pending'],
                ['title' => 'Performance optimization', 'description' => 'Optimasi performa platform untuk user banyak', 'status' => 'pending']
            ],
            'Aplikasi Fitness Tracking Personal' => [
                ['title' => 'Activity tracking sensors', 'description' => 'Implementasi sensor tracking aktivitas fisik', 'status' => 'completed'],
                ['title' => 'Data visualization', 'description' => 'Membuat visualisasi data aktivitas fitness', 'status' => 'active'],
                ['title' => 'Personal recommendations', 'description' => 'Sistem rekomendasi personal berdasarkan data', 'status' => 'pending'],
                ['title' => 'Social features', 'description' => 'Fitur sosial untuk sharing progress', 'status' => 'pending']
            ]
        ];

        // For completed collaborations, make most todos completed
        if ($collaboration->status === 'completed') {
            $todos = $baseTodos[$collaboration->title] ?? $this->getGenericTodos();
            foreach ($todos as &$todo) {
                $todo['status'] = fake()->randomElement(['completed', 'completed', 'completed', 'active']); // 75% completed
            }
            return $todos;
        }

        // For active collaborations, mix of completed and pending
        if ($collaboration->status === 'active') {
            $todos = $baseTodos[$collaboration->title] ?? $this->getGenericTodos();
            foreach ($todos as &$todo) {
                $todo['status'] = fake()->randomElement(['completed', 'completed', 'active', 'pending']); // 50% completed, 25% active, 25% pending
            }
            return $todos;
        }

        return $this->getGenericTodos();
    }

    /**
     * Get test todos for test collaborations
     */
    private function getTestTodos($collaboration): array
    {
        if (str_contains($collaboration->title, 'Pending Test')) {
            return []; // No todos for pending test collaboration
        }

        if (str_contains($collaboration->title, 'Active Test')) {
            return [
                ['title' => 'Setup project environment', 'description' => 'Menyiapkan environment development project', 'status' => 'completed'],
                ['title' => 'Create project structure', 'description' => 'Membuat struktur folder dan file project', 'status' => 'completed'],
                ['title' => 'Implement core features', 'description' => 'Implementasi fitur-fitur utama aplikasi', 'status' => 'active'],
                ['title' => 'Write unit tests', 'description' => 'Menulis unit test untuk setiap komponen', 'status' => 'pending'],
                ['title' => 'Integration testing', 'description' => 'Testing integrasi antar komponen', 'status' => 'pending']
            ];
        }

        if (str_contains($collaboration->title, 'Completed Test')) {
            return [
                ['title' => 'Project planning', 'description' => 'Perencanaan detail project dan timeline', 'status' => 'completed'],
                ['title' => 'Requirements gathering', 'description' => 'Pengumpulan dan analisis kebutuhan', 'status' => 'completed'],
                ['title' => 'System design', 'description' => 'Perancangan arsitektur sistem', 'status' => 'completed'],
                ['title' => 'Development', 'description' => 'Implementasi semua fitur sistem', 'status' => 'completed'],
                ['title' => 'Testing and deployment', 'description' => 'Testing final dan deployment ke production', 'status' => 'completed']
            ];
        }

        return $this->getGenericTodos();
    }

    /**
     * Get generic todos for collaborations without specific mapping
     */
    private function getGenericTodos(): array
    {
        return [
            ['title' => 'Project planning', 'description' => 'Membuat rencana detail project', 'status' => 'completed'],
            ['title' => 'Requirements analysis', 'description' => 'Analisis kebutuhan sistem', 'status' => 'completed'],
            ['title' => 'System design', 'description' => 'Merancang arsitektur sistem', 'status' => 'active'],
            ['title' => 'Development phase', 'description' => 'Implementasi fitur utama', 'status' => 'active'],
            ['title' => 'Testing and QA', 'description' => 'Quality assurance dan testing', 'status' => 'pending'],
            ['title' => 'Documentation', 'description' => 'Membuat dokumentasi sistem', 'status' => 'pending']
        ];
    }
}
