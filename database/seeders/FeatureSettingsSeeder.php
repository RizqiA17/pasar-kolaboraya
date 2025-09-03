<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class FeatureSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Initialize new feature settings with default values
        SystemSetting::setValue(
            'connections_enabled',
            '1',
            'Controls whether users can create and manage connections'
        );

        SystemSetting::setValue(
            'collaborations_enabled',
            '1',
            'Controls whether users can create and manage collaborations'
        );

        SystemSetting::setValue(
            'user_actions_enabled',
            '1',
            'Controls whether users can perform actions like joining events, etc.'
        );
    }
}
