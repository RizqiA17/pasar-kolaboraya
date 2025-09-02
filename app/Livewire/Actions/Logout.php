<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        try {
            // Log the logout attempt for debugging
            if (Auth::check()) {
                Log::info('User logout initiated', [
                    'user_id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'session_id' => Session::getId()
                ]);
            }

            // Clear all authentication data
            Auth::guard('web')->logout();
            
            // Invalidate and regenerate session to prevent CSRF issues
            // Session::invalidate();
            // Session::regenerateToken();
            
            // Clear any cached user data
            if (function_exists('cache')) {
                cache()->forget('user_' . (Auth::id() ?? 'unknown'));
            }

            Log::info('User logout completed successfully');

            return redirect('/')->with('success', 'Anda telah berhasil logout.');
            
        } catch (\Exception $e) {
            Log::error('Logout error occurred', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'session_id' => Session::getId()
            ]);

            // Even if there's an error, try to clear the session
            try {
                Session::flush();
                Session::regenerateToken();
            } catch (\Exception $sessionError) {
                Log::error('Session cleanup failed during logout', [
                    'error' => $sessionError->getMessage()
                ]);
            }

            return redirect('/')->with('error', 'Terjadi kesalahan saat logout. Silakan coba lagi.');
        }
    }
}
