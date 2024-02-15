<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\MultiPurposeEmail;
use App\Models\{VerifyEmail, User};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiVerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function verifyEmail(Request $request)
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

    public function resendEmail()
    {
        $user = auth()->user();

        if ($user) {

            $customBaseUrl = env('FRONT_APP_URL');
            $randomString = Str::random(40);
            $expired = now()->addMinutes(60);
            $verifyMail = VerifyEmail::where('user_id', $user->id)->first();
            if ($verifyMail) {
                $verifyMail->update([
                    'user_id'=> $user->id,
                    'email' => $user->email,
                    'token' => Hash::make($randomString),
                    'expired_at' => $expired,
                ]);
            } else {
                VerifyEmail::create([
                    'user_id'=> $user->id,
                    'email' => $user->email,
                    'token' => Hash::make($randomString),
                    'expired_at' => $expired,
                ]);
            }
            
            $verificationUrl = rtrim($customBaseUrl). 'verify-email/?userId='.$user->id. '&token=' .$randomString. '&expired='.hash('sha256', $expired);
            $email_templates  = new EmailTemplateController();
            $get_template = $email_templates->get_template('job-seeker-verify-email');
            $originalContent = $get_template['desc'];
            
            $email_variables = [
                '[Name]' => $user->first_name.' '.$user->last_name,
                '[Account Verify Link]' => '<a href="'.$verificationUrl.'" target="_blank">'.env('APP_URL').'</a>',
            ];

            // echo $originalContent;

            foreach ($email_variables as $search => $replace) {
                $originalContent = str_replace($search, $replace, $originalContent);
            };

            $subject = "Verify Email Address";
            $To = $user->email;

            $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
            Mail::to($To)->send($email);

            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully!',
            ]);

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
