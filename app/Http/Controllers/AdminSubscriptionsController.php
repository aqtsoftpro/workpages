<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;

use Illuminate\Http\Request;

class AdminSubscriptionsController extends Controller
{
    public function index(){
        
        $records = Subscription::all();
        

        return  view('admin.subscriptions.index', compact('records'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
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

    public function edit(string $id)
    {
        $record = Package::find($id);

        return view('admin.subscriptions.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $location = Package::find($id);

        if($location->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' package updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(string $id)
    {
        $deleted_rec = Package::find($id);

        if(Package::destroy($id)) {

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
