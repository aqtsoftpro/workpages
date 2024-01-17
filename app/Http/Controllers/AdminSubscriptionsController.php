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

        $record = Subscription::findOrFail($id);

        $packages = Package::all();

        $this->authorize('update', $record);

        return view('admin.subscriptions.edit', compact('record', 'packages'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);
        $inputs = $request->all();
        // dd($inputs);
        $package = Package::findOrFail($request->package_id);

        $inputs['name'] = $package->name;

        $location = $subscription;

        if($location->update($inputs))
            {
                return redirect()->back()->with('success', ''.$package->name.' subscription updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(Subscription $subscription)
    {
        $this->authorize('delete', $subscription);

        $deleted_rec = $subscription;

        if($subscription->delete()) {

            return redirect()->route('subscriptions.index')
                        ->with('success',''.$deleted_rec->name.' subscription deleted successfully');
          } else {
            return redirect()->route('subscriptions.index')
                        ->with('error','Please try again!');
        }
    }

    public function history(){
        return  view('admin.subscriptions.history');
    }
}
