<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CsrfTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_csrf_token_is_generated_on_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertNotNull(Session::token());
        $this->assertTrue(Session::has('_token_created_at'));
    }

    public function test_csrf_token_refresh_endpoint_works()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $oldToken = Session::token();
        
        $response = $this->post('/csrf-token-refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'timestamp']);
        
        $newToken = $response->json('token');
        $this->assertNotEquals($oldToken, $newToken);
        $this->assertTrue(Session::has('_token_created_at'));
    }

    public function test_csrf_token_refresh_requires_authentication()
    {
        $response = $this->post('/csrf-token-refresh');
        
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthenticated']);
    }

    public function test_session_activity_is_tracked()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/dashboard');
        
        $this->assertTrue(Session::has('last_activity'));
        $this->assertTrue(Session::has('_token_created_at'));
    }

    public function test_dashboard_loads_without_csrf_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang');
    }

    public function test_csrf_token_is_valid_after_session_extension()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate old token
        Session::put('_token_created_at', time() - 1800); // 30 minutes ago
        
        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
        $this->assertTrue(Session::has('_token_created_at'));
        
        // Token should be refreshed by middleware
        $tokenAge = time() - Session::get('_token_created_at');
        $this->assertLessThan(1800, $tokenAge); // Should be less than 30 minutes
    }
}
