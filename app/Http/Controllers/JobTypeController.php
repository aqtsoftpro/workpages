<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobTypeController extends Controller
{
    public function index(JobType $jobType){
        return response()->json($jobType->all());
    }

    public function show(JobType $jobType){
        return response()->json($jobType);
    }

    public function store(JobType $jobType, Request $request){
        try{
            $jobType->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Job Type created successfully',
                'jobType' => $jobType
            ]);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(JobType $jobType, Request $request){
        try{
            $jobType->update($request->all());
            return response()->json([
                'status' => 'jobType updated',
                'message' => 'Job Type updated successfully',
                'jobType' => $jobType
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(JobType $jobType){
        $jobType->delete();
        return response()->json([
            'status' => 'jobType deleted',
            'message' => 'Job Type deleted successfully'
        ]);
    }

    public function filter_type_of_employments()
    {
        
        $jobs_types = DB::table('job_types')
        ->Join('jobs', 'job_types.id', '=', 'jobs.job_type_id')
        ->select( 'jobs.job_type_id', DB::raw('COUNT(jobs.job_type_id) as counts'))
        ->groupBy('jobs.job_type_id')
        ->orderBy('job_types.name', 'DESC')
        ->get();
       
        $jobs_types_filter_with_count = array();
        $i = 0;
        foreach($jobs_types as $job_type)
        {
            $getType = JobType::where('id', $job_type->job_type_id)->first()->toArray();
            $jobs_types_filter_with_count[$i]['id'] = $job_type->job_type_id;
            $jobs_types_filter_with_count[$i]['name'] = $getType['name'];
            $jobs_types_filter_with_count[$i]['counts'] = $job_type->counts;
            $i++;
        }

        return response()->json($jobs_types_filter_with_count);

    }
}
