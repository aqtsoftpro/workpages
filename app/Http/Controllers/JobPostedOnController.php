<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Exception;
use App\Models\JobType;
use App\Models\JobPostedOn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobPostedOnController extends Controller
{
    public function filter_job_posted_on()
    {
        $job_posted_on = JobPostedOn::orderByDesc('name')->get()->toArray();

        // Your existing date
        $currentDate = Carbon::today();
        $originalDate = $currentDate->format('Y-m-d'); // Example date
        
        // Convert the original date to a Carbon instance
        $carbonDate = Carbon::parse($originalDate);


        $i = 0;
        foreach ($job_posted_on  as $post_on)
        {

            $daysToSubtract = $post_on['value'];
            $newDate = $carbonDate->subDays($daysToSubtract);
            $formattedNewDate = $newDate->format('Y-m-d');

            $jobs  = Job::select(DB::raw('count(*) as counts')) 
                    ->whereDate('created_at', '>=', $formattedNewDate )->first()->toArray();

            $poston_filter_with_count[$i]['id'] = $post_on['value'];
            $poston_filter_with_count[$i]['name'] = $post_on['name'];
            $poston_filter_with_count[$i]['counts'] = $jobs['counts'];
            $i++;        
        }

        return response()->json($poston_filter_with_count);
    }
}
