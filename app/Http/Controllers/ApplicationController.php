<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\{Application, Notification};
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use Illuminate\Support\Facades\DB;
use App\Models\{SiteSettings, Job};
use App\Http\Controllers\EmailTemplateController;
use App\Mail\MultiPurposeEmail;
use App\Jobs\MultiPurposeEmailJob;
use Illuminate\Support\Facades\Mail;


class ApplicationController extends Controller
{
    public function index(Application $application){
        return response()->json(ApplicationResource::collection($application->all()));
    }

    public function show(Application $application){
        return response()->json(new ApplicationResource($application));
    }

    public function store(Application $application, Request $request){

        $appData =  Application::where([
                'user_id' => $request->user_id,
                'job_id' => $request->job_id
                ])->first();
        // fileUplaod script
        if (!$appData) {
            DB::beginTransaction();
            try{
    
                $fileExtension = $request->cv->getClientOriginalExtension();
                $fileName = 'resume-' . $request->user_id . '.' . $fileExtension;
                $request->cv->storeAs('public', $fileName);
    
                $application->create([
                    'user_id' => $request->user_id,
                    'company_id' => $request->company_id,
                    'status_id' => $request->status_id,
                    'cv' => env('APP_URL') . 'storage/' . $fileName,
                    'job_id' => $request->job_id,
                    'experience' => $request->experience,
                    'salary' => $request->salary
                ]);
                $job = Job::with('company.owner')->find($request->job_id);
                DB::commit();
                if (isset($application)) {
                    Notification::create([
                        'company_id' => $request->company_id,
                        'job_id' => $request->job_id,
                        'type' => '_notification_job_activity',
                        'name' => 'Job Alert',
                        'job_title' => $job->job_title,
                        'company_id' => $request->company_id,
                        'salary' => $request->salary,
                        'desc' => 'This is notification for job application for job seeker',
                        'package' => 'No Package'
                    ]);
                    $customBaseUrl = env('FRONT_APP_URL');
                    $verificationUrl = rtrim($customBaseUrl). 'company/dashboard';
                    $email_templates  = new EmailTemplateController();
                    $get_template = $email_templates->get_template('company-recieve-application');
                    $originalContent = $get_template['desc'];
                    // $application->load('company.owner');
                    $email_variables = [
                        '[username]' => $job->company?->owner?->name,
                        '[company_name]' => $job->company?->name,
                        '[job_title]' => $job->job_title,
                        '[site_url]' => '<a href="'.$verificationUrl.'" target="_blank">Company dashboard</a>',                        
                        '[profile_link]' => '<a href="'.$verificationUrl.'" target="_blank">Company dashboard</a>',                        
                    ];

                    foreach ($email_variables as $search => $replace) {
                        $originalContent = str_replace($search, $replace, $originalContent);
                    };

                    $subject = "New Candidate Applied";
                    $To = $job->company?->owner?->email;
                    $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
                    Mail::to($To)->send($email);

                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job Application Sent!',
                    'data' => $job
                ]);
            } catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'You have already applied for this job!',
                'data' => $appData
            ]);
        }
    }

    public function update(Application $application, Request $request){
        try{
            $application->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Application updated!',
                'application' => $application
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request){
        
        $application = Application::find($request->application_id);
 
        $application->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Job Application deleted!'
        ]);
    }

    public function getApplicationsByUserId($user_id, Request $request){

        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();

        if($request->pageId)
            {
                $offset = $request->pageId*$listing_rows_count['meta_val'];

                $applications = Application::where('user_id', $user_id)->offset($offset)
                ->limit($listing_rows_count['meta_val'])
                ->get();
            }
            else
            {
                $offset = 0;
            }

        $total_counts = Application::where('user_id', $user_id)->count();

        $applications = Application::where('user_id', $user_id)->offset($offset)
            ->limit($listing_rows_count['meta_val'])
            ->get();

        $all_jobs  = array(
            'Listing' => ApplicationResource::collection($applications),
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );
        
            return response()->json($all_jobs);

        // return ApplicationResource::collection($applications);
    }

    public function getApplicationsByCompany(Request $request, Application $application)
    {
        $application = $application->with('user')->where('company_id', $request->company_id)->get();
        return ApplicationResource::collection($application);
    }

    public function updateCandidateApplication(Request $request){
        $application = Application::with('user', 'job.company')->find($request->application_id);
        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found!',
            ], 404);
        }

        $customBaseUrl = env('FRONT_APP_URL').'user/dashboard';
        $email_templates  = new EmailTemplateController();
        $get_template = $email_templates->get_template('short-listed-email');
        $originalContent = $get_template['desc'];
                    
        $email_variables = [
            '[username]' => $application->user?->name,
            '[job_title]' => $application->job?->job_title,
            '[company_name]' => $application->job?->company?->name,
            '[profile_link]' => '<a href="'.$customBaseUrl.'" target="_blank">'.env('FRONT_APP_URL').'</a>',
        ];

        foreach ($email_variables as $search => $replace) {
            $originalContent = str_replace($search, $replace, $originalContent);
        };

        $subject = "Application Accepted";
        $To = $application->user?->email;
        $email = new MultiPurposeEmail($subject, $originalContent, $customBaseUrl);
        Mail::to($To)->send($email);

        switch($request->status){
            case 'shortlist':
                $application->status_id = 3;
                break;
            case 'reject':
                $application->status_id = 5;
                break;
        }
        $application->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Application status updated!',
            'data' => $application
        ]);
    }

    public function CandidateAppiedOnJob($user_id,  $job_id)
    {
        $applied_status =  Application::where('user_id', $user_id)->where('job_id', $job_id)->get()->toArray();

        if($applied_status)
            {
                $applied_status = array(
                    'applied_status' => true,
                );
            }
            else
            {
                $applied_status = array(
                    'applied_status' => false,
                );
            }

        return response()->json($applied_status);
    }

}
