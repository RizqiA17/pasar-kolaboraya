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
        if ($request->user()->hasVerifiedEmail()) {
            // If already verified, check approval status
            if ($request->user()->isPendingApproval()) {
                return redirect()->route('auth.pending-approval');
            } elseif ($request->user()->isRejected()) {
                return redirect()->route('auth.rejected');
            } elseif ($request->user()->isApproved()) {
                return redirect()->route('dashboard');
            }
        }

        $request->fulfill();

        // After email verification, check approval status
        if ($request->user()->isPendingApproval()) {
            return redirect()->route('auth.pending-approval');
        } elseif ($request->user()->isRejected()) {
            return redirect()->route('auth.rejected');
        } elseif ($request->user()->isApproved()) {
            return redirect()->route('dashboard');
        }

        // Default fallback
        return redirect()->route('auth.pending-approval');
    }

}
