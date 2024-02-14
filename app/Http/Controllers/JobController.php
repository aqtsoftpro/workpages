<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Models\Category;
use App\Models\SiteSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Job $job){
        return response()->json(JobResource::collection($job->all()));
    }

    public function show(Job $job){
        return response()->json(new JobResource($job));
    }

    public function store(Job $job, Request $request){
        try{

            // $newRequest = new Request();
            // $job_data = $request->all();
            // $job_data['job_key'] = Str::random(9);
            // $job_data['job_slug'] = Str::slug($request->job_title);
            // $newRequest->merge($job_data);

            $job_key = Str::random(9);
            $job_slug = Str::slug($request->job_title);

            // $request->put('job_key', $job_key);
            // $request->put('job_slug', $job_slug);


            $expiration_date = Carbon::parse($request->expiration);

            $dataToAdd = [
                'job_key' =>  $job_key,
                'job_slug' =>  $job_slug,
                'expiration' =>  $expiration_date->format('Y-m-d'),
            ];
            

            $request->merge($dataToAdd);

            $job = Job::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Job created successfully',
                'job' => $job
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request,  $id){
        try{
            // print_r($request->all());
            $job = Job::findOrFail($id);

            $expiration_date = Carbon::parse($request->expiration);

            

            // return response()->json($dataToAdd);

            if($job->job_title != $request->job_title)
            {
                $job_slug = Str::slug($request->job_title);
                $dataToAdd = [
                    'job_slug' =>  $job_slug,
                    'expiration' =>  $expiration_date->format('Y-m-d'),
                ];
                
            }
            else
            {
                $dataToAdd = [
                    'expiration' =>  $expiration_date->format('Y-m-d'),
                ];
            }
            
            $request->merge($dataToAdd);
      
            $job->update($request->all());
          
            return response()->json([
                'status' => 'success',
                'message' => 'Job updated!',
                'job' => $job
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Job $job){
        $job->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Job has been deleted!'
        ]);
    }

    public function search_jobs(Request $request, Job $job){

        $q = $job->newQuery();
        $q->where('status', 'active');
        if(isset($request->keyword)){
            $q->where('job_title', 'LIKE', '%'.$request->keyword.'%');
        }

        if(isset($request->category_id)){
            $q->where('category_id', '=' ,$request->category_id);
        }


        if(isset($request->location_id)){
            $q->where('location_id', '=',  $request->location_id);
        }

        return response()->json(JobResource::collection($q->orderBy('expiration', 'desc')->get()));

    }

    public function companyJobs(Request $request, Job $job, $company_id)
    {
        $q = $job->newQuery();
        $q->where(['status'=>'active', 'company_id'=> $company_id]);
        return response()->json(JobResource::collection($q->orderBy('expiration', 'desc')->get()));
    }

    public function jobDetail($job_key, Job $job)
    {

        $q = $job->newQuery();
        $q->where('job_key', $job_key);
        // $q->where('job_slug', 'software-engineer');
      
        return response()->json(JobResource::collection($q->get()));
    }

    public function categoryJobs($cat_slug, Job $job)
    {

        $category = Category::where('slug', $cat_slug)->first()->toArray();
        
        $q = $job->newQuery();
        $q->where(['category_id'=> $category['id'], 'status' => 'active']);
      
        return response()->json(JobResource::collection($q->orderBy('expiration', 'desc')->get()));
    }

    public function latestJobs(Request $request, Job $job)
    {
        $latest_jobs = Job::limit(6)->where('status', 'active')
            ->orderBy('expiration', 'desc')
            ->get();

        return response()->json(JobResource::collection($latest_jobs));
    }

    public function featuredJobs(Request $request, Job $job)
    {
        $latest_jobs = Job::limit(4)
            ->where(['featured'=> 1, 'status'=> 'active'])
            ->orderBy('expiration', 'desc')
            ->get();

        return response()->json(JobResource::collection($latest_jobs));
    }

    

    public function FilteredJobs(Request $request, Job $job)
    {
        // print_r($request->jobTypes);
        // echo $request->jobSalaryRange;    
        // DB::enableQueryLog();
        // die();

        $q = $job->newQuery();
        $q->where('status', 'active');
        
        if(!empty($request->jobCategories)){
            $q->whereIn('category_id', explode(",", $request->jobCategories));
        }

        if(!empty($request->jobTypes)){
            $q->whereIn('job_type_id', explode(",", $request->jobTypes));
        }

        if(!empty($request->jobSalaryRange)){
            $price_range = explode('-', $request->jobSalaryRange);
            $q->where('salary_from', '>=', $price_range[0]);
            $q->where('salary_to', '<=', $price_range[1] );
        }

        // $jobs  = $q->get()->toArray();
        // print_r($jobs);
        // $query = DB::getQueryLog();
        // dd($query);

        // return response()->json(request()->query('jobCategories'));
        return response()->json(JobResource::collection($q->get()));
    }

  

    public function JobsListing(Request $request, Job $job)
    {
        $q = $job->newQuery();
        $q->where('status', 'active');
        $currentDate = Carbon::today();
        $originalDate = $currentDate->format('Y-m-d');
        
        $carbonDate = Carbon::parse($originalDate);

        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();

        if($request->pageId)
            {
                $offset = $request->pageId*$listing_rows_count['meta_val'];
            }
            else
            {
                $offset = 0;
            }

        if(!empty($request->jobCategories)){
            $q->whereIn('category_id', explode(",", $request->jobCategories));
        }

        if(!empty($request->jobTypes)){
            $q->whereIn('job_type_id', explode(",", $request->jobTypes));
        }
        
        if(!empty($request->jobSalaryRange)){
            $price_range = explode('-', $request->jobSalaryRange);
            $q->where('salary_from', '>=', $price_range[0]);
            $q->where('salary_to', '<=', $price_range[1] );
        }

        if(!empty($request->JobPostedOn)){

            $newDate = $carbonDate->subDays($request->JobPostedOn);
            $formattedNewDate = $newDate->format('Y-m-d');

            $q->whereDate('created_at', '>=', $formattedNewDate );
        }

        $total_counts = $q->count();

        $jobs_listing = 
        JobResource::collection(
            $q->offset($offset)
            ->limit($listing_rows_count['meta_val'])
            ->get()
        );

        $all_jobs  = array(
            'Listing' => $jobs_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );

        return response()->json($all_jobs);
    }


    public function getCompanyJobs(Request $request, Job $job)
    {

        // echo $request->keyword;
        // print_r($request->all());
        $q = $job->newQuery();
        // $q->where('status', 'active');
        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();

        if(isset($request->pageId) && $request->pageId)
            {
                $offset = $request->pageId*$listing_rows_count['meta_val'];
            }
            else
            {
                $offset = 0;
            }

        if(isset($request->date) &&  $request->date !== 'null'){
            $q->whereDate('created_at', $request->date);
        }
            

        if(isset($request->keyword) && $request->keyword !== 'null'){
            $q->where('job_title', 'LIKE', '%'.$request->keyword.'%');
        }

        $total_counts = $q->count();    

        $jobs_listing = 
        JobResource::collection(
            $q->offset($offset)
            ->limit($listing_rows_count['meta_val'])
            ->orderBy('expiration', 'desc')
            ->get()
        );

        $all_jobs  = array(
            'Listing' => $jobs_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );    
        
        return response()->json($all_jobs);
    }
    
    public function updateJobStatus(Request $request, Job $job)
    {
        Job::where('id', $request->jobId)->update(['status'=> $request->jobStatus]);

        $job = Job::where('id', $request->jobId)->first()->toArray();
        if( $request->jobStatus == 'active')
        {
            return response()->json([
                'status' => 'success',
                'message' => $job['job_title'].' is enabled!'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'success',
                'message' => $job['job_title'].' is disabled!'
            ]);
        }
    }

}
