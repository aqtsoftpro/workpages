<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\{SiteSettings, Notification};
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
  
    public function mailChimpEmailLog(Request $request)
    {


        $mailChimpApiKey = SiteSettings::where('meta_key', '_mailchimp_api_key')->first()->toArray();
        $mailChimpListID = SiteSettings::where('meta_key', '_mailchimp_list_id')->first()->toArray();


        if($mailChimpApiKey)
        {

            $email = $request->newsletter_email;
            $apiKey = $mailChimpApiKey['meta_val'];
            $listId = $mailChimpListID['meta_val'];

            $data = [
                'email_address' => $email,
                'status' => 'subscribed', // or 'pending' for double opt-in
            ];

            $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members";

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode('apikey:' . $apiKey),
            ]);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // Handle the response as needed
            $result = json_decode($response, true);
            
            if($statusCode == 400)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email is already subscribed',

                ]);
            }
            elseif($statusCode == 200)
            {
                try {
                    $notification = Notification::create([
                        'type' => '_notification_newsletter',
                        'name' => 'Newsletter',
                        'package' => 'No Package',
                        'desc' => 'Newsletter subscribed by '.$email.'.'
                    ]);
                    return response()->json([
                        'status' => 'successs',
                        'message' => 'You have successfully subcribed newsletter',
    
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $th,
    
                    ]);
                }

            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something Went Wrong. Please Try Again Later',

                ]);
            }


        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went Wrong. Please Try Again Later',

            ]);
        }
    }

    public function CharityPost(Request $request)
    {
        $mailChimpApiKey = "0bc97559ccb0dbace7deefc59278efa0-us6" //SiteSettings::where('meta_key', '_mailchimp_api_key')->first()->toArray();
        $mailChimpListID = "aa90ec88ac"//SiteSettings::where('meta_key', '_mailchimp_list_id')->first()->toArray();
        if($mailChimpApiKey)
        {
            $email = $request->email;
            $apiKey = "0bc97559ccb0dbace7deefc59278efa0-us6" //$mailChimpApiKey['meta_val'];
            $listId = "aa90ec88ac"  //$mailChimpListID['meta_val'];

            $data = [
                'email_address' => $email,
                'status' => 'subscribed', // or 'pending' for double opt-in
                'merge_fields'  => [
                    'FNAME'     => $request->name,
                    'LNAME'     => $request->name,
                    'COMPANY'   => $request->company,
                    'MESSAGE' => $request->message,
                ]
            ];



            $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members";

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode('apikey:' . $apiKey),
            ]);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // Handle the response as needed
            $result = json_decode($response, true);

            dd($result);
            
            if($statusCode == 400)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email is already subscribed',

                ]);
            }
            elseif($statusCode == 200)
            {
                try {
                    $notification = Notification::create([
                        'type' => '_notification_newsletter',
                        'name' => 'Newsletter',
                        'package' => 'No Package',
                        'desc' => 'Newsletter subscribed by '.$email.'.'
                    ]);
                    return response()->json([
                        'status' => 'successs',
                        'message' => 'You have successfully subcribed newsletter',
    
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $th,
    
                    ]);
                }

            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something Went Wrong. Please Try Again Later',

                ]);
            }


        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something Went Wrong. Please Try Again Later',

            ]);
        }
    }

}
