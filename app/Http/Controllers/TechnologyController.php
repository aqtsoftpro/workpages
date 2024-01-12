<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{

    public function index()
    {
        $records = Technology::orderBy('name', 'ASC')->get();
        return view('admin.technologies.index', compact('records'));
    }

    public function create()
    {
        return view('admin.technologies.create');
    }
    

    public function store(Request $request)
    {

        $added_rec = Technology::create($request->all());

        if($added_rec)
        {
            return redirect()->route('technologies.index')
                        ->with('success',''.$request->name.' technology added successfully.');
        }
        else
        {
            return redirect()->route('technologies.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = Technology::find($id);

        return view('admin.technologies.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $technology = Technology::find($id);

        if($technology->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' technology updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = Technology::find($id);

        if(Technology::destroy($id)) {

            return redirect()->route('technologies.index')
                        ->with('success',''.$deleted_rec->name.' technology deleted successfully');
          } else {
            return redirect()->route('technologies.index')
                        ->with('error','Please try again!');
        }
    }
    
    
    // public function index(technology $technology){
    //     return response()->json($technology->all());
    // }

    // public function show(technology $technology){
    //     return response()->json($technology);
    // }

    // public function store(technology $technology, Request $request){
    //     try{
    //         $newtechnology = $technology->create($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'technology Created!',
    //             'location' => $newLocation
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function update(technology $technology, Request $request){
    //     try{
    //         $technology->update($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'technology Updated!',
    //             'location' => $technology
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function destroy(technology $technology){
    //     $technology->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'technology Deleted!'
    //     ]);
    // }


}
