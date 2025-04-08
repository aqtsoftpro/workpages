<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\SubAccess;
use App\Models\Subscription;

use Illuminate\Http\Request;

class AdminSubscriptionsController extends Controller
{
    public function index(){
        $this->authorize('viewAny', Subscription::class);

        $records = Subscription::with('company')
            ->where(function ($query) {
                $query->where('subscription_status', 0)
                    ->orWhereNull('subscription_status');
            })
            ->latest()
            ->get();

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

    public function subscribers(){
        $this->authorize('viewAny', Subscription::class);

        $records = Subscription::with('company')->where('subscription_status', 1)->latest()->get();
        // dd($records);
        return  view('admin.subscriptions.subscribers', compact('records'));
    }


    public function subscriberEdit($id)
    {

        $record = Subscription::findOrFail($id);

        $packages = Package::all();

        $this->authorize('update', $record);

        return view('admin.subscriptions.subscriber_edit', compact('record', 'packages'));
    }

    public function updateSubscriber(Request $request, Subscription $subscription)
    {

        $package = Package::findOrFail($request->package_id);

        $this->authorize('update', $subscription);
        $inputs['status'] = 'subscribed'; // Update relevant subscriber fields

        if ($subscription->update($inputs)) {

            $package = Package::findOrFail($request->package_id);


            $expire = now()->addDays(4);
            switch ($package->interval) {
                case 'day':
                    $expire = now()->addDays($package->interval_count);
                    break;
                case 'month':
                    $expire = now()->addMonths($package->interval_count);
                    break;
                case 'year':
                    $expire = now()->addYears($package->interval_count);
                    break;
                default:
                    $expire = now()->addDays(7);
                    break;
            }

            $sub_access = SubAccess::create([
                    'user_id' => $request->user_id,
                    'subscription_id' => $subscription->id,
                    'post_for' => $package->post_for,
                    'allow_ads' => $package->allow_ads,
                    'allow_edits' => $package->allow_edits,
                    'allow_ref' => $package->allow_ref,
                    'allow_right' => $package->allow_right,
                    'allow_others' => $package->allow_others,
                    'h_s_screen' => $package->h_s_screen,
                    'allow_interview' => $package->allow_interview,
                    'recruiter_dash' => $package->recruiter_dash,
                    'casual_portal' => $package->casual_portal,
                    'emp_directory' => $package->emp_directory,
                    'rec_support' => $package->rec_support,
                    'cv_credit' => $package->cv_credit,
                    'msg_credit' => $package->msg_credit,
                    'cv_access' => $package->cv_access,
                    'expired_at' => $expire,
                    'edit_title' => $package->edit_title,
                    'edit_categ' => $package->edit_categ,
                    'edit_body' => $package->edit_body,
                    'delete_ad' => $package->delete_ad
            ]);


            return redirect()->back()->with('success', 'Subscriber details updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again!');
        }
    }

}
