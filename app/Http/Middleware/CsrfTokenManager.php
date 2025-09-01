<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CsrfTokenManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only handle authenticated users
        if (Auth::check()) {
            $this->manageCsrfToken();
        }

        return $next($request);
    }

    /**
     * Manage CSRF token to prevent expiration
     */
    protected function manageCsrfToken(): void
    {
        try {
            $currentTime = time();
            
            // Check if token creation time exists
            if (!Session::has('_token_created_at')) {
                Session::put('_token_created_at', $currentTime);
                Log::info('CSRF token creation time initialized', [
                    'user_id' => Auth::id(),
                    'session_id' => Session::getId()
                ]);
            }

            // Check token age
            $tokenAge = $currentTime - Session::get('_token_created_at', 0);
            
            // Refresh token if it's older than 20 minutes
            if ($tokenAge > 1200) { // 20 minutes
                $oldToken = Session::token();
                
                // Regenerate token
                Session::regenerateToken();
                Session::put('_token_created_at', $currentTime);
                
                Log::info('CSRF token refreshed by CsrfTokenManager', [
                    'user_id' => Auth::id(),
                    'old_token_age' => $tokenAge,
                    'old_token' => substr($oldToken, 0, 10) . '...',
                    'new_token' => substr(Session::token(), 0, 10) . '...',
                    'session_id' => Session::getId()
                ]);
            }

            // Update last activity
            Session::put('last_activity', $currentTime);
            
        } catch (\Exception $e) {
            Log::error('Error managing CSRF token', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'session_id' => Session::getId()
            ]);
        }
    }
}
