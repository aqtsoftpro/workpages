<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EmployeeAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAvailabilityController extends Controller
{

    public function index()
    {
        $records = EmployeeAvailability::orderBy('name', 'ASC')->get();
        return view('admin.employee_availability.index', compact('records'));
    }

    public function subrubs_list()
    {
        $suburb = Suburb::orderBy('name', 'ASC')->get();
        return response()->json($suburb);
    }

    public function create()
    {
        return view('admin.employee_availability.create');
    }


    public function store(Request $request)
    {
        $added_rec = EmployeeAvailability::create($request->all());

        if($added_rec)
        {
            return redirect()->route('employee_availability.index')
                        ->with('success',''.$request->name.' added successfully.');
        }
        else
        {
            return redirect()->route('employee_availability.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = EmployeeAvailability::find($id);

        return view('admin.employee_availability.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $location = EmployeeAvailability::find($id);

        if($location->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = EmployeeAvailability::find($id);

        if(EmployeeAvailability::destroy($id)) {

            return redirect()->route('employee_availability.index')
                        ->with('success',''.$deleted_rec->name.' deleted successfully');
          } else {
            return redirect()->route('employee_availability.index')
                        ->with('error','Please try again!');
        }
    }


    public function employee_availability_list()
    {
        $employee_availability = EmployeeAvailability::orderBy('name', 'ASC')->get();
        return response()->json($employee_availability);
    }




}
