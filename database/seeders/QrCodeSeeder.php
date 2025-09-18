<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class QrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate QR codes for all existing users
        $users = User::whereNull('qr_code')->get();
        
        foreach ($users as $user) {
            $user->generateQrCode();
            $this->command->info("Generated QR code for user: {$user->name}");
        }
        
        $this->command->info("QR codes generated for {$users->count()} users");
    }
}