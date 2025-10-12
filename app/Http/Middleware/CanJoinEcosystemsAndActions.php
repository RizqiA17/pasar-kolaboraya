<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CanJoinEcosystemsAndActions
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

        /** @var User $user */
        $user = Auth::user();

        // Super admin can access everything
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Check if user can join ecosystems and actions (tamu and partisipan only)
        if (!$user->canJoinEcosystemsAndActions()) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya pengguna tamu dan partisipan yang dapat bergabung dengan ekosistem dan aksi kolektif.');
        }

        return $next($request);
    }
}
