<?php

namespace App\Http\Controllers;

use App\Models\{JobAd, Subscription, Company, SiteSettings, Job};
use Illuminate\Http\Request;
use App\Http\Resources\JobAdResource;
use Carbon\Carbon;

class JobAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getAds()
    {
        $ads = JobAd::with('job')->whereDate('ends_at','>', now())->get();
    }
    public function index(Request $request, JobAd $job_ad)
    {
        $user = auth()->user();
        $company = Company::where('owner_id', $user->id)->first();
        // echo $request->keyword;
        // print_r($request->all());
        $q = $job_ad->newQuery();
        $q->with('job')->where('user_id', $user->id);
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
            $q->where('title', 'LIKE', '%'.$request->keyword.'%');
        }

        $total_counts = $q->count();    

        $ads_listing = 
        JobAdResource::collection(
            $q->offset($offset)
            ->limit($listing_rows_count['meta_val'])
            ->orderBy('ends_at', 'desc')
            ->get()
        );

        $all_ads  = array(
            'Listing' => $ads_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );
        // dd($all_ads);
        return response()->json($all_ads);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $subscription = Subscription::with('package')->where('user_id', auth()->id())->whereDate('ends_at', '>', now())->firstOrFail();
            $total_ads = JobAd::where('subscription_id', $subscription->id)->count();
            if ($subscription->package->count > $total_ads) {
                $inputs = $request->all();
                $inputs['user_id'] = auth()->id();
                $inputs['subscription_id'] = $subscription->id;
                $inputs['ends_at'] = now()->addDays(30);
                $inputs['user_id'] = auth()->id();
                $expired = Carbon::parse($subscription->ends_at);
                $leftDays = $expired->diffInDays(Carbon::now());
                if ($leftDays > 30 ) {
                    $inputs['ends_at'] = now()->addDays(30);
                } else {
                    $inputs['ends_at'] = now()->addDays($leftDays);
                }
                JobAd::create($inputs);
                return response()->json(['status'=> 'success', 'message'=> 'Job successfully add for advertisement']);
            } else {
                return response()->json(['status'=> 'error', 'message'=> 'please subscribe a plan to post new ad']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error', 'message'=> $th]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($job_ad)
    {
        try {
            $job_ad = JobAd::find($job_ad);
            return response()->json($job_ad->load('job'));
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobAd $job_ad)
    {
        $job_ad->update([
            'description' => $request->description,
            'status' => $request->status ?? $job_ad->status,
        ]);
        return response()->json(['status'=> 'success', 'message'=> 'advertisement successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobAd $jobAd)
    {
        //
    }
}
