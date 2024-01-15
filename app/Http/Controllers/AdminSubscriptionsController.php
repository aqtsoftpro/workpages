<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;

use Illuminate\Http\Request;

class AdminSubscriptionsController extends Controller
{
    public function index(){
        $this->authorize('viewAny', Subscription::class);

        $records = Subscription::with('company')->get();
        // dd($records);
        return  view('admin.subscriptions.index', compact('records'));
    }

    public function create()
    {
        $this->authorize('create', Subscription::class);

        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Subscription::class);

        $added_rec = Package::create($request->all());

        if($added_rec)
        {
            return redirect()->route('subscriptions.index')
                        ->with('success',''.$request->name.' Subscription added successfully.');
        }
        else
        {
            return redirect()->route('subscriptions.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit($id)
    {
        $record = Package::findOrFail($id);

        $this->authorize('update', $record);

        return view('admin.subscriptions.edit', compact('record'));
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
        $deleted_rec = $package;

        if(Package::destroy($package->id)) {

            return redirect()->route('subscriptions.index')
                        ->with('success',''.$deleted_rec->name.' package deleted successfully');
          } else {
            return redirect()->route('subscriptions.index')
                        ->with('error','Please try again!');
        }
    }

    public function history(){
        return  view('admin.subscriptions.history');
    }
}
