<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Initialize system settings
        SystemSetting::setValue(
            'login_enabled',
            '1',
            'Controls whether users can login to the system. Only super admins can login when disabled.'
        );

        SystemSetting::setValue(
            'maintenance_mode',
            '0',
            'Controls whether the system is in maintenance mode'
        );

        SystemSetting::setValue(
            'registration_enabled',
            '1',
            'Controls whether new users can register'
        );
    }
}
