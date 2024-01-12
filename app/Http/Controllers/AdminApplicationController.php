<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index(){

        $records = Application::get();



        return view('admin.applications.index', compact('records'));
    }

    public function applications(){

        $applications = Application::paginate('10');

        return view('admin.jobs.applications', compact('applications'));
    }

    public function change_status(Request $request){
        $job = Job::find($request->job_id);
        $job->status = $request->status;
        $job->save();
        return redirect()->back();
    }
}
