<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class AdminPackagesController extends Controller
{
    public function index(){

        $this->authorize('viewAny', Package::class);

        $records = Package::all();

        return  view('admin.packages.index', compact('records'));
    }

    public function create()
    {
        $this->authorize('create', Package::class);

        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Package::class);

        $added_rec = Package::create($request->all());

        if($added_rec)
        {
            return redirect()->route('packages.index')
                        ->with('success',''.$request->name.' Subscription added successfully.');
        }
        else
        {
            return redirect()->route('packages.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit(Package $package)
    {
        $this->authorize('update', $package);

        $record = $package;

        return view('admin.packages.edit', compact('record'));
    }

    public function update(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $location = $package;

        if($location->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' package updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(Package $package)
    {
        $this->authorize('delete', $package);

        $deleted_rec = $package;

        if(Package::destroy($package->id)) {

            return redirect()->route('packages.index')
                        ->with('success',''.$deleted_rec->name.' package deleted successfully');
          } else {
            return redirect()->route('packages.index')
                        ->with('error','Please try again!');
        }
    }

    public function history(){
        return  view('admin.packages.history');
    }
}
