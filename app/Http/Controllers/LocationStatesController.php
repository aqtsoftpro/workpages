<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use App\Models\LocationStates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationStatesController extends Controller
{

    public function index()
    {
        $records = LocationStates::orderBy('name', 'ASC')->get();

        // echo "<pre>";
        //     print_r($records);
        // echo "</pre>";
        
        // die();

        return view('admin.location_states.index', compact('records'));
    }

    public function create()
    {
        $locations = Location::orderBy('name', 'ASC')->get();
        return view('admin.location_states.create', compact('locations'));
    }
    

    public function store(Request $request)
    {
        // die();
        $added_rec = LocationStates::create($request->all());

        if($added_rec)
        {
            return redirect()->route('location_states.index')
                        ->with('success',''.$request->name.' location added successfully.');
        }
        else
        {
            return redirect()->route('location_states.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = LocationStates::find($id);

        $locations = Location::orderBy('name', 'ASC')->get();
        return view('admin.location_states.edit', compact('record', 'locations'));
    }

    public function update(Request $request, string $id)
    {
        $location = LocationStates::find($id);

        if($location->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' location updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = LocationStates::find($id);

        if(LocationStates::destroy($id)) {

            return redirect()->route('location_states.index')
                        ->with('success',''.$deleted_rec->name.' location deleted successfully');
          } else {
            return redirect()->route('location_states.index')
                        ->with('error','Please try again!');
        }
    }
    
    
    public function States(LocationStates $locationstates){
        return response()->json($locationstates->all());
    }

    // public function show(Location $location){
    //     return response()->json($location);
    // }

    // public function store(Location $location, Request $request){
    //     try{
    //         $newLocation = $location->create($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Location Created!',
    //             'location' => $newLocation
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function update(Location $location, Request $request){
    //     try{
    //         $location->update($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Location Updated!',
    //             'location' => $location
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function destroy(Location $location){
    //     $location->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Location Deleted!'
    //     ]);
    // }


    public function filter_companies_location()
    { 
        
            $company_locations = DB::table('locations')
            ->Join('companies', 'locations.id', '=', 'companies.location_id')
            ->select( 'companies.location_id', DB::raw('COUNT(companies.id) as counts'))
            ->groupBy('companies.location_id')
            ->orderBy('locations.name', 'DESC')
            ->get();

            $company_location_filter_with_count = array();
            $i = 0;
            foreach($company_locations as $locations)
            {
                $getType = Location::where('id', $locations->location_id)->first()->toArray();
                $company_location_filter_with_count[$i]['id'] = $locations->location_id;
                $company_location_filter_with_count[$i]['name'] = $getType['name'];
                $company_location_filter_with_count[$i]['counts'] = $locations->counts;
                $i++;
            }
    
            return response()->json($company_location_filter_with_count);
    }


}
