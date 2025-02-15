<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EmployeeAvailibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAvailibilityController extends Controller
{

    public function index()
    {
        $records = EmployeeAvailibility::orderBy('name', 'ASC')->get();
        return view('admin.employee_availibility.index', compact('records'));
    }

    public function subrubs_list()
    {
        $suburb = Suburb::orderBy('name', 'ASC')->get();
        return response()->json($suburb);
    }

    public function create()
    {
        return view('admin.employee_availibility.create');
    }


    public function store(Request $request)
    {
        $added_rec = EmployeeAvailibility::create($request->all());

        if($added_rec)
        {
            return redirect()->route('employee_availibility.index')
                        ->with('success',''.$request->name.' added successfully.');
        }
        else
        {
            return redirect()->route('employee_availibility.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = EmployeeAvailibility::find($id);

        return view('admin.employee_availibility.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $location = EmployeeAvailibility::find($id);

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
        $deleted_rec = EmployeeAvailibility::find($id);

        if(EmployeeAvailibility::destroy($id)) {

            return redirect()->route('employee_availibility.index')
                        ->with('success',''.$deleted_rec->name.' deleted successfully');
          } else {
            return redirect()->route('employee_availibility.index')
                        ->with('error','Please try again!');
        }
    }


    public function employee_availibility_list()
    {
        $employee_availibility = EmployeeAvailibility::orderBy('name', 'ASC')->get();
        return response()->json($employee_availibility);
    }




}
