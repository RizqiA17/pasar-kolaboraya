<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionRefresh
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
            // Check if session is about to expire (within 10 minutes)
            $lastActivity = Session::get('last_activity', 0);
            $currentTime = time();
            $timeDiff = $currentTime - $lastActivity;
            
            // If session is active for more than 10 minutes, extend it
            if ($timeDiff > 600) { // 10 minutes
                Session::put('last_activity', $currentTime);
                
                // Also refresh CSRF token if needed
                $tokenAge = $currentTime - Session::get('_token_created_at', 0);
                if ($tokenAge > 1800) { // 30 minutes
                    Session::regenerateToken();
                    Session::put('_token_created_at', $currentTime);
                }
            }
            
            // Always update last activity for authenticated requests
            Session::put('last_activity', $currentTime);
        }

        return $next($request);
    }
}
