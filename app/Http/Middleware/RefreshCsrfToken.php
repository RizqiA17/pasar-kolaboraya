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
        // Only refresh token for authenticated users and non-GET requests
        if (Auth::check() && !$request->isMethod('GET')) {
            // Check if token is about to expire (older than 1 hour)
            $tokenAge = time() - Session::get('_token_created_at', 0);
            
            if ($tokenAge > 3600) { // 1 hour in seconds
                // Regenerate CSRF token
                Session::regenerateToken();
                Session::put('_token_created_at', time());
                
                // Log token refresh for debugging
                Log::info('CSRF token refreshed', [
                    'user_id' => Auth::id(),
                    'old_token_age' => $tokenAge,
                    'session_id' => Session::getId()
                ]);
            }
        }

        return $next($request);
    }
}
