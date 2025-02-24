<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MultiPurposeEmail;
use App\Mail\BulkEmail;
use Twilio\Rest\Client;
use App\Models\{SubAccess, User, Company, SiteSettings};

use Exception;

class TwilioSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendSms(Request $request)
    {
        $twilioNumber = SiteSettings::where('meta_key', '_twilio_number')->first()->meta_val;
        $authToken = SiteSettings::where('meta_key', '_twilio_account_auth_token')->first()->meta_val;
        $accountSid = SiteSettings::where('meta_key', '_twilio_account_sid')->first()->meta_val;

        $message = $request->message;
        $userIds = explode(',', $request->user_id);

        if (empty($userIds)) {
            return response()->json(['status' => 'error', 'message' => 'No user infomation provided.']);
        }

        $successCount = 0;
        $failedUsers = [];

        foreach ($userIds as $id) {
            $user = User::find($id);

            if (!$user || empty($user->phone)) {
                $failedUsers[] = ['user_id' => $id, 'error' => 'User not found or phone number missing.'];
                continue;
            }
            $recieverNumber = preg_replace('/[^0-9]/', '', $user->phone);

            try {

                DB::beginTransaction();

                $subAccess = SubAccess::where('user_id', auth()->id())
                    ->where('msg_credit', '>', 0)
                    ->whereDate('expired_at', '>', now())
                    ->first();

                if ($subAccess) {
                    $subAccess->update(['msg_credit' => $subAccess->msg_credit - 1]);

                    $client = new Client($accountSid, $authToken);
                    $client->messages->create('+'.$recieverNumber, [
                        'from' => $twilioNumber,
                        'body' => $message
                    ]);

                    DB::commit();
                    $successCount++;
                } else {
                    throw new Exception('Insufficient message credits or subscription expired.');
                }


            } catch (Exception $e) {
                DB::rollBack();
                $failedUsers[] = ['user_id' => $id, 'error' => $e->getMessage()];
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'SMS successfully sent!',
            'success_count' => $successCount,
            'failed_users' => $failedUsers
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function sendEmail(Request $request)
    {

        $company = Company::where('owner_id', auth()->id())->first();
        $customBaseUrl = env('FRONT_APP_URL');

        $user_id = $request->user_id;
        $userIds = explode(',', $user_id);

        if($userIds && $company){
            foreach ($userIds as $id) {
                $user = User::find($id);

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

                // $verificationUrl = rtrim($customBaseUrl). 'user/dashboard';

                $subject = $request->subject;

                $To = $user->email;

                $email = new BulkEmail($subject, $originalContent);
                Mail::to($To)->send($email);

                // $email = new BulkEmail($subject, $body);

                // Mail::to($To)->send($email);

            }
            return response()->json(['status' => 'success', 'message' => 'Email successfully sent!']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Email not found!'], 404);
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
