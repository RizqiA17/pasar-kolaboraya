<?php

namespace Database\Seeders;

use App\Models\RegistrationKey;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first super admin user to be the creator
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            // Create a super admin if none exists
            $admin = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@pasar-kolaboraya.com',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'user_type' => 'partisipan',
                'approval_status' => 'approved',
                'assigned_role' => 'super_admin',
                'approved_at' => now(),
                'approved_by' => 1,
            ]);
        }

        // Create registration keys for each user type
        $keys = [
            [
                'key' => 'PART-2024-ABCD-EFGH',
                'user_type' => 'partisipan',
                'description' => 'Kode registrasi untuk partisipan - akses penuh ke ekosistem dan aksi kolektif',
                'max_usage' => 100,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'key' => 'TAMU-2024-IJKL-MNOP',
                'user_type' => 'tamu',
                'description' => 'Kode registrasi untuk tamu - hanya dapat terhubung dengan pengguna lain',
                'max_usage' => 50,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'key' => 'KOMU-2024-QRST-UVWX',
                'user_type' => 'komunitas',
                'description' => 'Kode registrasi untuk komunitas - hanya dapat terhubung dengan pengguna lain',
                'max_usage' => 30,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'key' => 'PART-UNLIMITED-2024',
                'user_type' => 'partisipan',
                'description' => 'Kode registrasi partisipan tanpa batas penggunaan',
                'max_usage' => null,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'key' => 'TEST-EXPIRED-2024',
                'user_type' => 'tamu',
                'description' => 'Kode registrasi yang sudah kadaluarsa (untuk testing)',
                'max_usage' => 10,
                'is_active' => true,
                'expires_at' => now()->subDay(),
                'created_by' => $admin->id,
            ],
        ];

        foreach ($keys as $keyData) {
            RegistrationKey::create($keyData);
        }

        $this->command->info('Registration keys created successfully!');
        $this->command->info('Available keys:');
        $this->command->info('- PART-2024-ABCD-EFGH (Partisipan, 100 uses)');
        $this->command->info('- TAMU-2024-IJKL-MNOP (Tamu, 50 uses)');
        $this->command->info('- KOMU-2024-QRST-UVWX (Komunitas, 30 uses)');
        $this->command->info('- PART-UNLIMITED-2024 (Partisipan, unlimited)');
        $this->command->info('- TEST-EXPIRED-2024 (Tamu, expired for testing)');
    }
}
