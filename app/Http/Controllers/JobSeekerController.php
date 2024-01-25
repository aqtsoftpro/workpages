<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\JobSeeker;
use App\Models\{Suburb, User};
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class JobSeekerController extends Controller
{

    public function index(Request $request)
    {
        
        if(isset($request->suburb_id))
            {
                $records =  Role::find(2)->users->where('suburb_id', $request->suburb_id);

                $get_suburb_id = $request->suburb_id;
            }
            else
            {
                $records =  Role::find(2)->users;
                $get_suburb_id = '';
            }

    
        $suburbs = Suburb::get();

        return view('admin.job_seekers.index', compact('records', 'suburbs', 'get_suburb_id'));
    }

    // public function create()
    // {
    //     return view('admin.locations.create');
    // }


    public function store(Request $request)
    {
        $added_rec = Location::create($request->all());

        if($added_rec)
        {
            return redirect()->route('locations.index')
                        ->with('success',''.$request->name.' location added successfully.');
        }
        else
        {
            return redirect()->route('locations.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = JobSeeker::find($id);

        $suburbs = Suburb::get();

        return view('admin.job_seekers.edit', compact('record', 'suburbs'));
    }

    public function show(string $id)
    {
        $record = JobSeeker::find($id);
        // $record = $record->location;
        // dd($record);
        return view('admin.job_seekers.show', compact('record'));
    }

    public function update(Request $request, string $id)
    {

        $job_seeker = JobSeeker::find($id);
      
        if($job_seeker->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' job seeker updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = JobSeeker::find($id);

        if(JobSeeker::destroy($id)) {

            return redirect()->route('job_seekers.index')
                        ->with('success',''.$deleted_rec->name.' job seeker deleted successfully');
          } else {
            return redirect()->route('job_seekers.index')
                        ->with('error','Please try again!');
        }
    }





}
