<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Mail\MultiPurposeEmail;
use App\Jobs\MultiPurposeEmailJob;
use App\Models\User;
use App\Jobs\NotificationEmailJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;


class ForgotPasswordController extends Controller
{
    public function forgot() 
    {
        $credentials = request()->validate(['email' => 'required|email']);

        // if (request()->user()) {

        //     $customBaseUrl = env('FRONT_APP_URL');

        //     $linkurl = URL::temporarySignedRoute(
        //         'verification.verify',
        //         now()->addMinutes(60),
        //         ['id' => request()->user()->id, 'hash' => sha1(request()->email)],
        //         false // This parameter ensures that the base URL is not included
        //     );

        //     $verificationUrl = rtrim($customBaseUrl, '/') . '/' . ltrim($linkurl, '/');

        //     $email_templates  = new EmailTemplateController();
        //     $get_template = $email_templates->get_template('job-seeker-verify-email');
        //     $originalContent = $get_template['desc'];
            
        //     $email_variables = [
        //         '[Name]' => request()->user()->name,
        //         '[Account Verify Link]' => '<a href="'.$verificationUrl.'" target="_blank">'.env('FRONT_APP_URL').'</a>',
        //     ];

        //     // echo $originalContent;

        //     foreach ($email_variables as $search => $replace) {
        //         $originalContent = str_replace($search, $replace, $originalContent);
        //     };

        //     $subject = "Verify Email Address";
        //     $To = $request->email;

        //     MultiPurposeEmailJob::dispatch($To, $subject, $originalContent, $verificationUrl);
        // }

        Password::sendResetLink($credentials);
        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return response(['status'=> 'User updated', 'message' => 'Password updated successfully'], 200);
    }


    public function getToken(Request $request)
    {
        $email = DB::table('password_reset_tokens')->where('token', $request->token)->pluck('email');
        return response(["data" => $email], 200);

        // dd($request->all());
        // if (!empty($request)) {
        //     return response(["data" => $request], 200);
        // }
        // else {
        //     return response(["msg" => 'token failed to match'], 200);
        // }
    }
}
