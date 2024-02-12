<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Listeners\LogVerifiedUser;


class ApiVerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($request->user());
        // if ($request->user()->hasVerifiedEmail()) {
        //     return response()->json([
        //         'status' => 'success',
        //         'data' => $request->user(),
        //         'message' => 'User alreay verified!'
        //     ]);
        // }
        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));


        // }
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $request->user(),
        //     'message' => 'User verified successfully!'
        // ]);

        $user = User::findOrFail($request->userId);
        
        if (! hash_equals((string) $request->token, $user->getEmailVerificationToken())) {
            return response()->json(['message' => 'Mismatch token'], 403);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully']);
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
