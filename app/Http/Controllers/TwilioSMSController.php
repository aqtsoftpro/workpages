<?php

namespace App\Http\Controllers;

use App\Models\SubAccess;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Exception;

class TwilioSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendSms(Request $request)
    {
        $receiverNumber = $request->receiver_number;
        $message = $request->message;
        try {
  
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $twilio_number = env("TWILIO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            return response()->json(['status'=> 'success', 'message', 'message sent successfully']);
  
        } catch (Exception $e) {
            return response()->json(['status'=> 'error', 'message',  $e->getMessage()], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
