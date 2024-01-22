<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SiteSettings;
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
                    return response()->json([
                        'status' => 'successs',
                        'message' => 'You have successfully subcribed newsletter',
    
                    ]);
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
