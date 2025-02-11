<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
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
            return $this->redirectByRole($request->user());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectByRole($request->user());
    }

    private function redirectByRole($user): RedirectResponse
    {
        if ($user->hasRole('superadmin')) {
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME . '?verified=1');
        } else {
            return redirect()->intended(RouteServiceProvider::USER_HOME . '?verified=1');
        }
    }
}
