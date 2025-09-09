<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EcosystemBuilderOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        // Super admin can access everything
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user is approved ecosystem builder
        if (!$user->isApprovedEcosystemBuilder()) {
            if ($user->hasPendingEcosystemBuilderApproval()) {
                return redirect()->back()->with('error', 'Akses ditolak. Permintaan Anda untuk menjadi Ecosystem Builder sedang menunggu persetujuan admin.');
            } else {
                return redirect()->back()->with('error', 'Akses ditolak. Hanya ecosystem builders yang disetujui yang dapat mengakses fitur ini.');
            }
        }

        return $next($request);
    }
}