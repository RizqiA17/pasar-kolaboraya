<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for guests
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Skip for super admins
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has user_type (new registration system)
        if ($user->user_type) {
            // If user is pending approval, redirect to pending page
            if ($user->isPendingApproval()) {
                return redirect()->route('auth.pending-approval');
            }

            // If user is rejected, redirect to rejection page
            if ($user->isRejected()) {
                return redirect()->route('auth.rejected');
            }

            // If user is approved, continue
            if ($user->isApproved()) {
                return $next($request);
            }
        }

        // For users without user_type (old system), allow access
        return $next($request);
    }
}
