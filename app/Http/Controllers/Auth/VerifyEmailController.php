<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $route = 'profile.setup';
        if ($request->user()->created_at != $request->user()->updated_at) {
            $route = 'dashboard';
        }
        // dd([
        //     '$route' => $route,
        //     'kondisi' =>$request->user()->created_at != $request->user()->updated_at,
        //     'created_at' => $request->user()->created_at,
        //     'updated_at' => $request->user()->updated_at,
        // ]);

        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirect($route);
        }

        $request->fulfill();

        return $this->redirect($route);
    }

    private function redirect($route)
    {
        return redirect()->intended(route($route, absolute: false) . '?verified=1');
    }
}
