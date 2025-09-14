<?php

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing seeder order and dependencies...\n\n";

try {
    // Test the order that should work
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
            break; // Stop on first failure
        }
    }

    echo "\nSeeder order test completed!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
