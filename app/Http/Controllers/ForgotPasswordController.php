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
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class ForgotPasswordController extends Controller
{
    public function forgot() 
    {

        $credentials = request()->validate(['email' => 'required|email']);
        $user = User::where('email', request()->email)->first();

        $customBaseUrl = env('FRONT_APP_URL');
        $randomString = Str::random(40);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($randomString), 'created_at' => now()]
        );

        // DB::table('password_reset_tokens')->insert([
        //     'email' => $user->email,
        //     'token' => Hash::make($randomString),
        //     'created_at' => now(),
        // ]);

        $verificationUrl = rtrim($customBaseUrl). 'reset-password/' .$randomString. '?email='.$user->email;

        $email_templates  = new EmailTemplateController();
        $get_template = $email_templates->get_template('job-seeker-verify-email');
        $originalContent = $get_template['desc'];
        
        $email_variables = [
            '[Name]' => $user->first_name.' '.$user->last_name,
            '[Admin Password Reset]' => '<a href="'.$verificationUrl.'" target="_blank">'.env('APP_URL').'</a>',
        ];

        // echo $originalContent;

        foreach ($email_variables as $search => $replace) {
            $originalContent = str_replace($search, $replace, $originalContent);
        };

        $subject = "Password Recovery Email";
        $To = $user->email;

        // MultiPurposeEmailJob::dispatch($To, $subject, $originalContent, $verificationUrl);

        $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
        Mail::to($To)->send($email);
        return response()->json([
            'status' => 'success',
            "msg" => 'Reset password link sent on your email id.',
        ]);

    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        $email = $data->email;

        if ($email && Hash::check($request->token, $data->token)) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $request->only('email', 'password', 'password_confirmation', 'token');
                $user->update([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ]);
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                return response(['status'=> 'success', 'message' => 'Password updated successfully'], 200);
            }
            else {
                return response(['status'=> 'error', 'message' => 'User not found'], 404);
            }
        }

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => Hash::make($request->password),
        //             'remember_token' => Str::random(60),
        //         ])->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // return response(['status'=> 'User updated', 'message' => 'Password updated successfully'], 200);
    }


    public function getToken(Request $request)
    {
        $data = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        $email = $data->email;

        if ($email && Hash::check($request->token, $data->token)) {
            return response($email, 200);
        }

        // dd($request->all());
        // if (!empty($request)) {
        //     return response(["data" => $request], 200);
        // }
        // else {
        //     return response(["msg" => 'token failed to match'], 200);
        // }
    }
}
