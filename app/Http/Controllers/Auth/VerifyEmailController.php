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
            if ($request->user()->hasRole('Job Seeker') || $request->user()->hasRole('Employer')) {
                return redirect()->away(env('FRONT_APP_URL'));
            } else {
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            }
            
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($request->user()->hasRole('Job Seeker') || $request->user()->hasRole('Employer')) {
            return redirect()->away(env('FRONT_APP_URL'));
        } else {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }
    }
}
