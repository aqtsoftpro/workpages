<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Mail\MultiPurposeEmail;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{

    public function index()
    {

    }
    public function contact_us(Request $request)
    {


        $subject = "Your Email Subject";
        $content = "Your email content goes here.";
        //$result = Mail::to('jamshed76@gmail.com')->cc('jamshed@dpdweb.com')
        //$result = Mail::to('jamshed76@gmail.com')->send(new MultiPurposeEmail($subject, $content));

        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        
        return response()->json([
            'status' => 'success',
            'message' => 'Message Sent Sucessfully!',
        ]);
    }

    public function verify_account()
        {
            echo "<pre>";
            $email_templates  = new EmailTemplateController();
            $get_template = $email_templates->get_template('company-account-verify');
            $originalContent = $get_template['desc'];

            $email_variables = [
                '[Name]' => 'John',
                '[Account Verify Link]' => '<a href="'.env('FRONT_APP_URL').'" target="_blank">'.env('FRONT_APP_URL').'</a>',
            ];

            print_r($email_variables);

            foreach ($email_variables as $search => $replace) {
                $originalContent = str_replace($search, $replace, $originalContent);
            }


            echo $originalContent;
            echo "</pre>";
     
            $subject = "Account verification Email";
            
            //$result = Mail::to('jamshed76@gmail.com')->send(new MultiPurposeEmail($subject, $originalContent));


        } 




}
