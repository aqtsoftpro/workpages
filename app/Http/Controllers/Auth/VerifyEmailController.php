<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Listeners\LogVerifiedUser;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->hasRole('Super Admin')) {
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            } else {
                return redirect()->away(env('FRONT_APP_URL'));
            }
        }
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            if ($request->user()->hasRole('Super Admin')) {
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            } else {
                return redirect()->away(env('FRONT_APP_URL'));
            }
        }
    }
}
