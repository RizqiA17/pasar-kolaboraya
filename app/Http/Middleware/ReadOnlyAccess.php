<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ReadOnlyAccess
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

        // Super admin and ecosystem builders have full access
        if ($user->isSuperAdmin() || $user->isEcosystemBuilder()) {
            return $next($request);
        }

        // Regular users can only view (GET requests)
        if ($request->isMethod('GET')) {
            return $next($request);
        }

        // Block non-GET requests for regular users
        return redirect()->back()->with('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
    }
}