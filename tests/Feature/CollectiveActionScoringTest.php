<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CollectiveAction;
use App\Models\PasarKolaboraya;
use App\Models\User;
use App\Models\Ecosystem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectiveActionScoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_aksi_score_returns_correct_structure()
    {
        // Create a collective action
        $collectiveAction = CollectiveAction::factory()->create([
            'status' => 'active',
            'scale' => 'besar',
            'scope' => 'national'
        ]);

        $score = $collectiveAction->calculateAksiScore();

        // Assert the structure
        $this->assertIsArray($score);
        $this->assertArrayHasKey('activity_score', $score);
        $this->assertArrayHasKey('impact_score', $score);
        $this->assertArrayHasKey('participation_score', $score);
        $this->assertArrayHasKey('engagement_score', $score);
        $this->assertArrayHasKey('completion_score', $score);
        $this->assertArrayHasKey('diversity_score', $score);
        $this->assertArrayHasKey('aksi_score', $score);
        $this->assertArrayHasKey('details', $score);

        // Assert all scores are numeric
        $this->assertIsFloat($score['activity_score']);
        $this->assertIsFloat($score['impact_score']);
        $this->assertIsFloat($score['participation_score']);
        $this->assertIsFloat($score['engagement_score']);
        $this->assertIsFloat($score['completion_score']);
        $this->assertIsFloat($score['diversity_score']);
        $this->assertIsFloat($score['aksi_score']);

        // Assert scores are between 0 and 100
        $this->assertGreaterThanOrEqual(0, $score['activity_score']);
        $this->assertLessThanOrEqual(100, $score['activity_score']);
        $this->assertGreaterThanOrEqual(0, $score['impact_score']);
        $this->assertLessThanOrEqual(100, $score['impact_score']);
    }

    public function test_activity_score_for_active_action()
    {
        $collectiveAction = CollectiveAction::factory()->create([
            'status' => 'active'
        ]);

        $score = $collectiveAction->calculateAksiScore();
        $this->assertEquals(100, $score['activity_score']);
    }

    public function test_activity_score_for_completed_action()
    {
        $collectiveAction = CollectiveAction::factory()->create([
            'status' => 'completed'
        ]);

        $score = $collectiveAction->calculateAksiScore();
        $this->assertEquals(100, $score['activity_score']);
    }

    public function test_activity_score_for_planning_action()
    {
        $collectiveAction = CollectiveAction::factory()->create([
            'status' => 'planning'
        ]);

        $score = $collectiveAction->calculateAksiScore();
        $this->assertEquals(0, $score['activity_score']);
    }

    public function test_impact_score_calculation()
    {
        $collectiveAction = CollectiveAction::factory()->create([
            'scale' => 'besar',
            'scope' => 'international'
        ]);

        $score = $collectiveAction->calculateAksiScore();
        
        // Besar (3) × International (3) = 9
        // 9 / 300 * 100 = 3%
        $this->assertEquals(3.0, $score['impact_score']);
    }

    public function test_pasar_kolaboraya_collective_action_quality()
    {
        $pasarKolaboraya = PasarKolaboraya::factory()->create();
        
        // Create collective actions
        CollectiveAction::factory()->create([
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'status' => 'active',
            'scale' => 'besar',
            'scope' => 'national'
        ]);

        CollectiveAction::factory()->create([
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'status' => 'completed',
            'scale' => 'sedang',
            'scope' => 'local'
        ]);

        $quality = $pasarKolaboraya->calculateCollectiveActionQuality();
        
        $this->assertIsFloat($quality);
        $this->assertGreaterThanOrEqual(0, $quality);
        $this->assertLessThanOrEqual(100, $quality);
    }

    public function test_empty_collective_actions_returns_zero()
    {
        $pasarKolaboraya = PasarKolaboraya::factory()->create();
        
        $quality = $pasarKolaboraya->calculateCollectiveActionQuality();
        
        $this->assertEquals(0, $quality);
    }
}

