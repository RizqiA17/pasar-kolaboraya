<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActivePasarKolaboraya
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for super admin
        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return $next($request);
        }

        // Skip check for certain routes that don't require active session
        $exemptRoutes = [
            'dashboard',
            'profile.view',
            'settings.profile',
            'settings.password',
            'settings.appearance',
            'settings.profile-settings',
            'pasar-kolaboraya.select',
            'pasar-kolaboraya.join-request',
            'logout'
        ];

        if (in_array($request->route()?->getName(), $exemptRoutes)) {
            return $next($request);
        }

        // Check if user has active Pasar Kolaboraya
        if (Auth::check() && !Auth::user()->hasActivePasarKolaboraya()) {
            // Check if user has any Pasar Kolaboraya
            if (Auth::user()->hasPasarKolaborayas()) {
                // User has Pasar Kolaboraya but no active session, redirect to selection
                return redirect()->route('pasar-kolaboraya.select');
            } else {
                // User has no Pasar Kolaboraya at all, redirect to dashboard with message
                return redirect()->route('dashboard')->with('info', 'Anda belum bergabung dengan Pasar Kolaboraya mana pun. Hubungi admin untuk diundang.');
            }
        }

        return $next($request);
    }
}
