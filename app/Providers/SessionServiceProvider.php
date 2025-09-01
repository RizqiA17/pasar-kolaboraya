<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Listen for session events
        $this->listenForSessionEvents();
        
        // Extend session lifetime for authenticated users
        $this->extendSessionForAuthenticatedUsers();
    }

    /**
     * Listen for session events to handle CSRF token issues
     */
    protected function listenForSessionEvents(): void
    {
        // Before session is stored
        Session::beforeStore(function ($session) {
            if (Auth::check()) {
                // Ensure CSRF token creation time is set
                if (!$session->has('_token_created_at')) {
                    $session->put('_token_created_at', time());
                }
                
                // Update last activity
                $session->put('last_activity', time());
            }
        });

        // After session is stored
        Session::afterStore(function ($session) {
            if (Auth::check()) {
                // Log session activity for debugging
                Log::debug('Session updated', [
                    'user_id' => Auth::id(),
                    'session_id' => $session->getId(),
                    'last_activity' => $session->get('last_activity'),
                    'token_created_at' => $session->get('_token_created_at')
                ]);
            }
        });
    }

    /**
     * Extend session lifetime for authenticated users
     */
    protected function extendSessionForAuthenticatedUsers(): void
    {
        // Check if user is authenticated and extend session if needed
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity', 0);
            $currentTime = time();
            
            // If session is active for more than 5 minutes, extend it
            if ($currentTime - $lastActivity > 300) { // 5 minutes
                Session::put('last_activity', $currentTime);
                
                // Also refresh CSRF token if it's older than 15 minutes
                $tokenAge = $currentTime - Session::get('_token_created_at', 0);
                if ($tokenAge > 900) { // 15 minutes
                    Session::regenerateToken();
                    Session::put('_token_created_at', $currentTime);
                    
                    Log::info('CSRF token refreshed by SessionServiceProvider', [
                        'user_id' => Auth::id(),
                        'old_token_age' => $tokenAge,
                        'session_id' => Session::getId()
                    ]);
                }
            }
        }
    }
}
