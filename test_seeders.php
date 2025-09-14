<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Seeder;

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing seeders...\n\n";

try {
    // Test each seeder individually
    $seeders = [
        'Database\Seeders\SystemSettingSeeder',
        'Database\Seeders\InterestSeeder', 
        'Database\Seeders\SkillSeeder',
        'Database\Seeders\ContributionSeeder',
        'Database\Seeders\EventCategorySeeder',
        'Database\Seeders\UserSeeder',
        'Database\Seeders\ProfileSeeder',
        'Database\Seeders\ConnectionSeeder',
        'Database\Seeders\SuperAdminSeeder',
        'Database\Seeders\ContainerSeeder',
        'Database\Seeders\ContainerUserSeeder',
        'Database\Seeders\PasarKolaborayaSeeder',
        'Database\Seeders\EcosystemBuilderSeeder',
        'Database\Seeders\CollectiveActionSeeder',
        'Database\Seeders\EcosystemContributionSeeder',
        'Database\Seeders\SurveySeeder',
        'Database\Seeders\SurveyResponseSeeder',
    ];

    foreach ($seeders as $seederClass) {
        echo "Testing {$seederClass}... ";
        
        try {
            $seeder = new $seederClass();
            $seeder->run();
            echo "✓ SUCCESS\n";
        } catch (Exception $e) {
            echo "✗ FAILED: " . $e->getMessage() . "\n";
        }
    }

    echo "\nAll seeders tested!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
