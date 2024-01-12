<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminJobsController extends Controller
{
    // public function index(){

    //     $jobs = Job::paginate('10');

    //     return view('admin.jobs.index', compact('jobs'));
    // }

    public function index()
    {
        $this->authorize('viewAny', Job::class);
        $records_closed = Job::whereDate('expiration', '<=' , Carbon::now()
                            ->format('Y-m-d'))
                            // ->where('status', 'inactive')
                            ->orderBy('job_title', 'ASC')
                            ->get();

              

        $records_opened = Job::whereDate('expiration', '>=' , Carbon::now()
                            ->format('Y-m-d'))
                            // ->where('status', 'active')
                            ->orderBy('job_title', 'ASC')
                            ->get();
        // 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')



        return view('admin.jobs.index', compact('records_closed', 'records_opened'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        $record = $job;

        return view('admin.jobs.edit', compact('record'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $job =  Job::where('id', $id)
       ->update([
           'status' => $request->status
        ]);

        if($job)
            {
                return redirect()->back()->with('success', ''.$request->name.' job status updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function applications(){

        $applications = Application::paginate('10');

        return view('admin.jobs.applications', compact('applications'));
    }

    public function change_status(Request $request){
        $job = Job::find($request->job_id);

        $this->authorize('update', $job);
        
        $job->status = $request->status;
        $job->save();
        return redirect()->back();
    }
}
