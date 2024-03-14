<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MultiPurposeEmail;
use Twilio\Rest\Client;
use App\Models\{SubAccess, User, Company};

use Exception;

class TwilioSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendSms(Request $request)
    {  
        // $receiverNumber = $request->receiver_number;
        $twilionumber = SiteSettings::where('meta_key', '_twilio_number')->first();
        $receiverNumber = $twilionumber->meta_val;

        $authToken = SiteSettings::where('meta_key', '_twilio_account_auth_token')->first();
        $authToken = $authToken->meta_val;
        $account_sid = SiteSettings::where('meta_key', '_twilio_account_sid')->first();
        $account_sid = $account_sid->meta_val;
        $message = $request->message;
        DB::beginTransaction();
        try {
  
            $sub_access = SubAccess::where('user_id', auth()->id())->where('msg_credit', '>', 0)->whereDate('expired_at', '>', now())->first();
            if ($sub_access) {
                $sub_access->update([
                    'msg_credit' => $sub_access->msg_credit - 1
                ]);
      
                $client = new Client($account_sid, $authToken);
                $client->messages->create($receiverNumber, [
                    'from' => $receiverNumber, 
                    'body' => $message]);
    
                DB::commit();
                return response()->json(['status'=> 'success', 'message', 'message sent successfully']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status'=> 'success', 'message',  $e->getMessage()], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendEmail(Request $request)
    {
        $company = Company::where('owner_id', auth()->id())->first();
        $user = User::find($request->user_id);
        $customBaseUrl = env('FRONT_APP_URL');
        if ($company && $user) {
            $email_templates  = new EmailTemplateController();
            $get_template = $email_templates->get_template('job-seeker-email');
            $originalContent = $get_template['desc'];
            
            $email_variables = [
                '[username]' => $user->name,
                '[company_name]' => $company->name.' address: '.$company->address,
                '[employer_message]' => $request->body,
            ];

            foreach ($email_variables as $search => $replace) {
                $originalContent = str_replace($search, $replace, $originalContent);
            };
            $verificationUrl = rtrim($customBaseUrl). 'user/dashboard';
            $subject = $request->subject;
            $To = $user->email;
            $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
            Mail::to($To)->send($email);
            return response()->json(['status' => 'success', 'message' => 'Email successfully sent!']);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Job seeker not found!'], 404);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(SubAccess $subAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubAccess $subAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubAccess $subAccess)
    {
        //
    }
}
