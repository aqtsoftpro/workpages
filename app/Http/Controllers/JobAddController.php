<?php

namespace App\Http\Controllers;

use App\Models\JobAd;
use Illuminate\Http\Request;

class JobAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getAds()
    {
        $ads = JobAd::with('job')->whereDate('ends_at','>', now())->get();
    }
    public function index()
    {
        //
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
                JobAd::create($request->all());
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
    public function show(JobAd $jobAd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobAd $jobAd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobAd $jobAd)
    {
        //
    }
}
