<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function index(JobCategory $jobCategory){
        return response()->json($jobCategory->all());
    }

    public function show(JobCategory $jobCategory){
        return response()->json($jobCategory);
    }

    public function store(Request $request, JobCategory $jobCategory){
        try{
            $jobCategory = $jobCategory->create($request->all());
            $response = [
                'status' => 'success',
                'message' => 'Job Category created successfully!',
                'data' => $jobCategory
            ];
            return response()->json($response);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(Request $request, JobCategory $jobCategory){
        try{
            $jobCategory->update($request->all());
            $response = [
                'status' => 'success',
                'message' => 'Job Category updated successfully!',
                'data' => $jobCategory
            ];
            return response()->json($response);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy(JobCategory $jobCategory){
        $jobCategory->delete();
        $response = [
            'status' => 'success',
            'message' => 'Job Category Deleted Successfully!',
        ];
        return response()->json($response);
    }
}
