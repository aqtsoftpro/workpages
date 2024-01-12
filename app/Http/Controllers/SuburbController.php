<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Suburb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuburbController extends Controller
{

    public function index()
    {
        $records = Suburb::orderBy('name', 'ASC')->get();
        return view('admin.suburbs.index', compact('records'));
    }

    public function subrubs_list()
    {
        $suburb = Suburb::orderBy('name', 'ASC')->get();
        return response()->json($suburb);
    }

    public function create()
    {
        return view('admin.suburbs.create');
    }
    

    public function store(Request $request)
    {
        $added_rec = Suburb::create($request->all());

        if($added_rec)
        {
            return redirect()->route('suburbs.index')
                        ->with('success',''.$request->name.' state added successfully.');
        }
        else
        {
            return redirect()->route('suburbs.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = Suburb::find($id);

        return view('admin.suburbs.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $location = Suburb::find($id);

        if($location->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' state updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = Suburb::find($id);

        if(Suburb::destroy($id)) {

            return redirect()->route('suburbs.index')
                        ->with('success',''.$deleted_rec->name.' state deleted successfully');
          } else {
            return redirect()->route('suburbs.index')
                        ->with('error','Please try again!');
        }
    }
    
    
    public function suburbs(Location $location){
        return response()->json($location->all());
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
        
            $company_suburbs = DB::table('suburbs')
            ->Join('companies', 'suburbs.id', '=', 'companies.location_id')
            ->select( 'companies.location_id', DB::raw('COUNT(companies.id) as counts'))
            ->groupBy('companies.location_id')
            ->orderBy('suburbs.name', 'DESC')
            ->get();

            $company_location_filter_with_count = array();
            $i = 0;
            foreach($company_suburbs as $suburbs)
            {
                $getType = Suburb::where('id', $suburbs->location_id)->first()->toArray();
                $company_location_filter_with_count[$i]['id'] = $suburbs->location_id;
                $company_location_filter_with_count[$i]['name'] = $getType['name'];
                $company_location_filter_with_count[$i]['counts'] = $suburbs->counts;
                $i++;
            }
    
            return response()->json($company_location_filter_with_count);
    }


}
