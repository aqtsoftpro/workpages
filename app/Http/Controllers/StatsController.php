<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StatsController extends Controller
{

    public function homeStats()
    {
        
        $companies_stats = Company::count();
        $candidates_stats = Role::find(2)->users->count();
        $livejobs_stats =  Job::count();

        $date = \Carbon\Carbon::today()->subDays(7);
        $new_jobs_stats = Job::where('created_at','>=',$date)->count();

        // print_r($companies_stats);

        $homePageStats = array(
            'companies_stats' => $companies_stats,
            'candidates_stats' => $candidates_stats,
            'livejobs_stats' => $livejobs_stats,
            'new_jobs_stats' => $new_jobs_stats,
         );

        return response()->json($homePageStats);
    }
    
}
