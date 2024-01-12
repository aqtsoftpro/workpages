<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Exception;
use App\Models\JobType;
use App\Models\SalaryRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryRangeController extends Controller
{
    public function filter_salary_range()
    {

        $salary_ranges = SalaryRange::orderByDesc('start_price')->get()->toArray();

        $i = 0;
        foreach ($salary_ranges  as $range)
        {
            $jobs  = Job::select(DB::raw('count(*) as counts')) 
                    ->where('salary_from', '>=', $range['start_price_value'] )
                    ->where('salary_to', '<=', $range['end_price_value'] )->first()->toArray();
            $salary_filter_with_count[$i]['id'] = $range['start_price_value'].'-'.$range['end_price_value'];
            $salary_filter_with_count[$i]['name'] = $range['start_price'].'-'.$range['end_price'];
            $salary_filter_with_count[$i]['counts'] = $jobs['counts'];
            $i++;        
        }



        return response()->json($salary_filter_with_count);

    }
}
