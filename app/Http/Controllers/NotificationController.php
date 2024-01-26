<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Models\Category;
use App\Models\Notification;
use App\Models\SiteSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
  
    public function notification_job_alert()
    {

        // $records = Notification::join('jobs', 'notifications.job_id', '=', 'jobs.id')
        // ->join('companies', 'notifications.company_id', '=', 'companies.id')
        // ->select(    
        //     'jobs.id as job_id',
        //     'companies.name as company_name',
        //     'jobs.location_id',
        //     'jobs.job_title',
        //     'jobs.salary_from',
        //     'jobs.salary_to'
        // )->get();

        $records = Notification::whereNotNull('job_id')->with('job.company')->get();
        return view('admin.notifications.notification_job_alert', compact('records'));

    }

    public function notification_package_subscription()
    {

        $records = Notification::join('jobs', 'notifications.job_id', '=', 'jobs.id')
        ->join('companies', 'notifications.company_id', '=', 'companies.id')
        ->select(    
            'jobs.id as job_id',
            'companies.name as company_name',
            'jobs.location_id',
            'jobs.job_title',
            'jobs.salary_from',
            'jobs.salary_to'
        )->get();
  
        return view('admin.notifications.notification_job_alert', compact('records'));
        
    }

}
