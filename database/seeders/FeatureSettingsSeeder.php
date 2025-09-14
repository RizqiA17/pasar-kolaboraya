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
        // Check if feature settings already exist
        if (SystemSetting::whereIn('key', ['connections_enabled', 'collaborations_enabled', 'user_actions_enabled'])->count() > 0) {
            $this->command->info('Feature settings already exist. Skipping feature setting creation.');
            return;
        }

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
