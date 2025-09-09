<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckFeatureAccess
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

        // Check feature access based on system settings with cascading rules
        switch ($feature) {
            case 'connections':
                if (!SystemSetting::isConnectionsEnabled()) {
                    return redirect()->back()->with('error', 'Fitur koneksi sedang dinonaktifkan oleh administrator.');
                }
                break;
                
            case 'collaborations':
                if (!SystemSetting::isCollaborationsEnabled()) {
                    return redirect()->back()->with('error', 'Fitur kolaborasi sedang dinonaktifkan oleh administrator.');
                }
                break;
                
            case 'ecosystems':
                if (!SystemSetting::isEcosystemsEnabled(Auth::user())) {
                    $user = Auth::user();
                    if ($user && $user->isEcosystemBuilder()) {
                        // Ecosystem builder should always have access - this shouldn't happen
                        break;
                    }
                    return redirect()->back()->with('error', 'Fitur ekosistem sedang dinonaktifkan untuk user biasa. Hanya ecosystem builder yang dapat mengakses fitur ini.');
                }
                break;
                
            case 'user_actions':
                if (!SystemSetting::isUserActionsEnabled()) {
                    return redirect()->back()->with('error', 'Aksi pengguna sedang dinonaktifkan oleh administrator.');
                }
                break;
                
            case 'collective_actions':
                if (!SystemSetting::isCollectiveActionsEnabled()) {
                    return redirect()->back()->with('error', 'Fitur aksi kolektif sedang dinonaktifkan oleh administrator. Aktifkan fitur aksi pengguna untuk menggunakan aksi kolektif.');
                }
                break;
                
            default:
                // Unknown feature, allow access
                break;
        }

        return $next($request);
    }
}
