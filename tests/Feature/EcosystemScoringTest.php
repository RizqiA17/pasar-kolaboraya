<?php

use App\Models\Ecosystem;
use App\Models\PasarKolaboraya;
use App\Models\User;
use App\Models\EcosystemContribution;
use App\Models\Contribution;
use App\Models\CollectiveActionEcosystemInvitation;

test('calculates ekosistem score correctly', function () {
    // Create test data
    $pasarKolaboraya = PasarKolaboraya::factory()->create();
    $user = User::factory()->create();
    
    $ecosystem = Ecosystem::create([
        'creator_id' => $user->id,
        'pasar_kolaboraya_id' => $pasarKolaboraya->id,
        'organization_name' => 'Test Organization',
        'ecosystem_title' => 'Test Ecosystem',
        'issues_addressed' => ['test issue'],
        'work_region' => 'Test Region',
        'existing_roles' => [1, 2, 3],
        'needed_roles' => [1, 2, 3, 4],
        'max_users' => 10,
        'terms_conditions' => 'Test terms',
        'description' => 'Test description',
        'is_active' => true,
        'auto_join_collective_actions' => false,
    ]);

    // Test with no data (should return all zeros)
    $score = $ecosystem->calculateEkosistemScore();
    
    expect($score)->toHaveKeys([
        'activation_score',
        'acceptance_score', 
        'completion_score',
        'diversity_score',
        'role_fit_score',
        'engagement_score',
        'ekosistem_score',
        'details'
    ]);
    
    expect($score['activation_score'])->toBe(0.0);
    expect($score['acceptance_score'])->toBe(0.0);
    expect($score['completion_score'])->toBe(0.0);
    expect($score['diversity_score'])->toBe(0.0);
    expect($score['role_fit_score'])->toBe(75.0); // 3/4 * 100
    expect($score['engagement_score'])->toBe(0.0);
    expect($score['ekosistem_score'])->toBe(12.5); // Average of all scores
});

test('calculates activation score correctly', function () {
    $pasarKolaboraya = PasarKolaboraya::factory()->create();
    $user = User::factory()->create();
    
    $ecosystem = Ecosystem::create([
        'creator_id' => $user->id,
        'pasar_kolaboraya_id' => $pasarKolaboraya->id,
        'organization_name' => 'Test Organization',
        'ecosystem_title' => 'Test Ecosystem',
        'issues_addressed' => ['test issue'],
        'work_region' => 'Test Region',
        'existing_roles' => [],
        'needed_roles' => [],
        'max_users' => 5,
        'terms_conditions' => 'Test terms',
        'description' => 'Test description',
        'is_active' => true,
        'auto_join_collective_actions' => false,
    ]);

    // Add 3 accepted users
    $users = User::factory()->count(3)->create();
    foreach ($users as $testUser) {
        $ecosystem->users()->attach($testUser->id, [
            'status' => 'accepted',
            'joined_at' => now()
        ]);
    }

    $score = $ecosystem->calculateEkosistemScore();
    
    // 3 accepted users out of 5 max = 60%
    expect($score['activation_score'])->toBe(60.0);
    expect($score['details']['accepted_members'])->toBe(3);
    expect($score['details']['max_users'])->toBe(5);
});

test('calculates acceptance rate correctly', function () {
    $pasarKolaboraya = PasarKolaboraya::factory()->create();
    $user = User::factory()->create();
    
    $ecosystem = Ecosystem::create([
        'creator_id' => $user->id,
        'pasar_kolaboraya_id' => $pasarKolaboraya->id,
        'organization_name' => 'Test Organization',
        'ecosystem_title' => 'Test Ecosystem',
        'issues_addressed' => ['test issue'],
        'work_region' => 'Test Region',
        'existing_roles' => [],
        'needed_roles' => [],
        'max_users' => 10,
        'terms_conditions' => 'Test terms',
        'description' => 'Test description',
        'is_active' => true,
        'auto_join_collective_actions' => false,
    ]);

    // Add 3 accepted and 1 rejected user
    $acceptedUsers = User::factory()->count(3)->create();
    foreach ($acceptedUsers as $testUser) {
        $ecosystem->users()->attach($testUser->id, [
            'status' => 'accepted',
            'joined_at' => now()
        ]);
    }
    
    $rejectedUser = User::factory()->create();
    $ecosystem->users()->attach($rejectedUser->id, [
        'status' => 'rejected'
    ]);

    $score = $ecosystem->calculateEkosistemScore();
    
    // 3 accepted out of 4 total decisions = 75%
    expect($score['acceptance_score'])->toBe(75.0);
    expect($score['details']['accepted_members'])->toBe(3);
    expect($score['details']['rejected_members'])->toBe(1);
    expect($score['details']['total_decisions'])->toBe(4);
});
