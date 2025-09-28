<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RefreshCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only refresh token for authenticated users
        if (Auth::check()) {
            // Check if token is about to expire (older than 30 minutes instead of 1 hour)
            $tokenAge = time() - Session::get('_token_created_at', 0);
            
            if ($tokenAge > 500) { // 30 minutes in seconds
                try {
                    // Regenerate CSRF token
                    Session::regenerateToken();
                    Session::put('_token_created_at', time());
                    
                    // Log token refresh for debugging
                    Log::info('CSRF token refreshed', [
                        'url' => $request->url(),
                        'method' => $request->method(),
                        'user_id' => Auth::id(),
                        'old_token_age' => $tokenAge,
                        'session_id' => Session::getId()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to refresh CSRF token', [
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                        'session_id' => Session::getId()
                    ]);
                }
            }
            
            // Ensure token creation time is set
            if (!Session::has('_token_created_at')) {
                Session::put('_token_created_at', time());
            }
        }

        return $next($request);
    }
}
