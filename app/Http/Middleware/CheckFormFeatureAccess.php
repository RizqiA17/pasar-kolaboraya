<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckFormFeatureAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        // Super admin selalu bisa mengakses semua fitur
        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return $next($request);
        }

        // Check feature access based on system settings
        switch ($feature) {
            case 'connections':
                if (!SystemSetting::isConnectionsEnabled()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Fitur koneksi sedang dinonaktifkan oleh administrator.',
                        'disabled' => true
                    ], 403);
                }
                break;
                
            case 'collaborations':
                if (!SystemSetting::isCollaborationsEnabled()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Fitur kolaborasi sedang dinonaktifkan oleh administrator.',
                        'disabled' => true
                    ], 403);
                }
                break;
                
            case 'user_actions':
                if (!SystemSetting::isUserActionsEnabled()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Aksi pengguna sedang dinonaktifkan oleh administrator.',
                        'disabled' => true
                    ], 403);
                }
                break;
                
            default:
                // Unknown feature, allow access
                break;
        }

        return $next($request);
    }
}
