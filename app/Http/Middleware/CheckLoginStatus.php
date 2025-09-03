<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckLoginStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if login is enabled
        if (!SystemSetting::isLoginEnabled()) {
            // If login is disabled, only allow super admins who are already logged in
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role !== 'super_admin') {
                    // Logout non-super admin users
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Sistem sedang dalam mode maintenance. Hanya super admin yang dapat masuk.');
                }
                // Super admin yang sudah login tetap bisa mengakses
                return $next($request);
            } else {
                // If not logged in and login is disabled, redirect to login with error
                return redirect()->route('login')->with('error', 'Sistem sedang dalam mode maintenance. Hanya super admin yang dapat masuk.');
            }
        }

        return $next($request);
    }
}
