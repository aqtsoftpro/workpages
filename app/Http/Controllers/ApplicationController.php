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
    
                $job = Job::find($request->job_id);
    
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
                }
                DB::commit();
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
        $application = $application->where('company_id', $request->company_id)->get();
        return ApplicationResource::collection($application);
    }

    public function updateCandidateApplication(Request $request){
        $application = Application::find($request->application_id);
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
