<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $profile = $user->profile;
            
            // Check if profile exists and has basic information
            $hasBasicInfo = $profile && (
                !empty($user->organization_name) ||
                !empty($user->phone_number) ||
                !empty($profile->vision)
            );
            
            // Check if user has skills or interests
            $hasSkillsOrInterests = $profile && (
                ($profile->skills && $profile->skills->count() > 0) ||
                ($profile->interests && $profile->interests->count() > 0)
            );
            
            // If profile is not complete and not already on profile setup page
            if (!$hasBasicInfo && !$hasSkillsOrInterests && !$request->routeIs('profile.setup')) {
                return redirect()->route('profile.setup');
            }
        }

        return $next($request);
    }
}





