<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Listeners\LogVerifiedUser;
use App\Models\{VerifyEmail, User};
use Illuminate\Support\Facades\Hash;

class ApiVerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $verifyMailData = VerifyEmail::where('user_id', $request->userId)->where('expired_at', '>=', now())->first();

        if ($user && $verifyMailData) {
            if (!Hash::check($request->token, $verifyMailData->token)) {
                return response()->json(['message' => 'Mismatch token'], 403);
            } else {
                $user->update([
                    'email_verified_at' => now(),
                ]);
                return response()->json(['message' => 'Email verified successfully']);
            }
        }
        else {
            return response()->json(['message' => 'User not found']);
        }

    }

    // public function verifyEmail(Request $request)
    // {
    //     $user = User::findOrFail($request->userId);
        
    //     if (! hash_equals((string) $request->token, $user->getEmailVerificationToken())) {
    //         // Token mismatch, handle error
    //     }

    //     $user->markEmailAsVerified();

    //     return response()->json(['message' => 'Email verified successfully']);
    // }

}
