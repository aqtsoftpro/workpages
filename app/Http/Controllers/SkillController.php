<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function index()
    {
        $records = Skill::orderBy('name', 'ASC')->get();
        return view('admin.skills.index', compact('records'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }
    

    public function store(Request $request)
    {

        $added_rec = Skill::create($request->all());

        if($added_rec)
        {
            return redirect()->route('skills.index')
                        ->with('success',''.$request->name.' skill added successfully.');
        }
        else
        {
            return redirect()->route('skills.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = Skill::find($id);

        return view('admin.skills.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $skill = Skill::find($id);

        if($skill->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' skill updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }


    public function destroy(string $id)
    {
        $deleted_rec = Skill::find($id);

        if(Skill::destroy($id)) {

            return redirect()->route('skills.index')
                        ->with('success',''.$deleted_rec->name.' skill deleted successfully');
          } else {
            return redirect()->route('skills.index')
                        ->with('error','Please try again!');
        }
    }
    
    
    // public function index(skill $skill){
    //     return response()->json($skill->all());
    // }

    // public function show(skill $skill){
    //     return response()->json($skill);
    // }

    // public function store(skill $skill, Request $request){
    //     try{
    //         $newskill = $skill->create($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'skill Created!',
    //             'location' => $newLocation
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function update(skill $skill, Request $request){
    //     try{
    //         $skill->update($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'skill Updated!',
    //             'location' => $skill
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function destroy(skill $skill){
    //     $skill->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'skill Deleted!'
    //     ]);
    // }


}
