<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sector;

class SectorController extends Controller
{

    public function index()
    {
        $records = Sector::orderBy('name', 'ASC')->get();
        return view('admin.sectors.index', compact('records'));
    }


    public function create()
    {
        return view('admin.sectors.create');
    }

    public function store(Request $request)
    {
        $added_rec = Sector::create($request->all());

        if($added_rec)
        {
            return redirect()->route('sectors.index')
                        ->with('success',''.$request->name.' Job sector added successfully.');
        }
        else
        {
            return redirect()->route('sectors.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $record = Sector::find($id);

        return view('admin.sectors.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $sector = Sector::find($id);

        if($sector->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' sector updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(string $id)
    {
        $deleted_rec = Sector::find($id);

        if(Sector::destroy($id)) {

            return redirect()->route('sectors.index')
                        ->with('success',''.$deleted_rec->name.' sector deleted successfully');
          } else {
            return redirect()->route('sectors.index')
                        ->with('error','Please try again!');
        }
    }
}
