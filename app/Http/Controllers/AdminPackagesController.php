<?php

namespace App\Http\Controllers;

use App\Models\{Package, Subscription, KeyPoint};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Laravel\Cashier\Cashier;

class AdminPackagesController extends Controller
{
    public function index(){

        $this->authorize('viewAny', Package::class);
        
        $records = Package::with('subscriptions')->get();

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

        $inputs = $request->all();

        Stripe::setApiKey(env('STRIPE_SECRET'));
        DB::beginTransaction();
        try {

            if ($request->price > 0) {
                // Create the product
                $product = \Stripe\Product::create([
                    'name' => $request->name,
                    'type' => 'service', // optional field
                    'description' => $request->description, // optional field
                ]);
                if ($product) {
                    // Create the price for the product
                    $price = \Stripe\Price::create([
                        'product' => $product->id,
                        'unit_amount' => $request->price * 100, // price per unit in USD
                        'currency' => 'usd',
                        'recurring' => [
                            'interval' => 'month',
                            'interval_count' => 6,
                            'usage_type' => 'licensed', // normally 'licensed'
                        ],
                    ]);

                    if ($price) {
                        $inputs['stripe_price_id'] = $price->id;
                        $inputs['stripe_product_id'] = $product->id;
                        $inputs['count'] = 9999999;
                    }
                }               
            }

            $added_rec = Package::create($inputs);
            if($added_rec){
                    // Validate the request data
                    $request->validate([
                        'icon.*' => 'required',
                        'title.*' => 'required',
                        'detail.*' => 'required',
                    ]);

                    // Store the data in your database or perform any other necessary action
                    foreach ($request->title as $key => $value) {
                        KeyPoint::create([
                            'package_id' => $added_rec->id,
                            'icon' => 'yes',
                            'title' => $value,
                            'detail' => $request->detail[$key],
                        ]);
                    }
                    DB::commit();
                return redirect()->route('packages.index')
                            ->with('success',''.$request->name.' Package added successfully.');
            }
            else
            {
                return redirect()->route('packages.index')
                            ->with('success','Something went wrong. Please try again.');
            }

        }
        catch(Exception $ex){
            DB::rollBack();
            //dd($ex->getMessage());
            return redirect()->route('admin.plans.index')->with('failed', $ex->getMessage());
        }
        
    }

    public function destroyKey(KeyPoint $keypoint)
    {   
        // dd($keypoint);  
        // $this->authorize('delete', $package);
        $keypoint = KeyPoint::findOrFail($keypoint->id);
        $deleted_rec = $keypoint;
        if($keypoint->delete()) {

            return redirect()->back()
                        ->with('success',''.$deleted_rec->title.' keypoint deleted successfully');
          } else {
            return redirect()->back()
                        ->with('error','Please try again!');
        }
    }


    //just check if it works or not
    public function session(Request $request){

        $package = Package::find($request->package);

        Stripe::setApiKey(env('STRIPE_SECRET'));


        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price'      => $package->stripe_price_id, // Replace with the ID of the price/plan you want to subscribe to
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'subscription',
            'success_url' => url('checkout/success/'.encrypt($package->id).'/{CHECKOUT_SESSION_ID}'),
            'cancel_url'  => url('/dashboard'),
        ]);

        return redirect()->away($session->url);
    }


    public function success($id, $session_id){

        $package = Package::find(decrypt($id));
        //dd($package->extra_users);
        // $cart = Cart::where(['user_id' => Auth::user()->id, 'package_id' => $package->id])->first();
        // if ($cart){
        //     $cart->delete();
        // }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($session_id, []);

        $payment_intent = PaymentIntent::all([
            'customer' => $session->customer,
            'limit' => 1,
        ]);

        // dd(auth()->user());

        Subscription::create([
            'user_id' => auth()->id(),
            'package_id'=> $package->id,
            'company_id' => auth()->user()->company->id,
            'name' => $package->name,
            'stripe_id' => $payment_intent->data[0]['id'],
            'stripe_price' => $package->price,
            'quantity' => 1,
            'stripe_status' => 'active',
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription Package has been updated');
    }

    public function edit(Package $package)
    {
        $this->authorize('update', $package);
        $record = Package::with('keypoints')->find($package->id);
        // dd($record);
        return view('admin.packages.edit', compact('record'));
    }

    public function update(Request $request, Package $package)
    {
        // dd('some thing done');
        $this->authorize('update', $package);
        $inputs = [
            'name' => $request->name,
            'price' => $request->price
        ];
        // $location = $package;
        $location = Package::with('keypoints')->findOrFail($package->id);

        if($location->update($inputs))
            {
                foreach ($location->keypoints as $key => $point) {
                    $point->delete();
                }
                $request->validate([
                    'icon.*' => 'required',
                    'title.*' => 'required',
                    'detail.*' => 'required',
                ]);

                // Store the data in your database or perform any other necessary action
                foreach ($request->icon as $key => $value) {
                    KeyPoint::create([
                        'package_id' => $package->id,
                        'icon' => $value,
                        'title' => $request->title[$key],
                        'detail' => $request->detail[$key],
                    ]);
                }


                // return redirect()->back()->with('success', ''.$request->name.' package updated successfully');
                return response()->json(['data' => $package, 'status'=> 'success', 'message'=> $request->name.' package updated successfully']);
            }
            else
            {
                // return redirect()->back()->with('success', 'Something went wrong. Please try again!');
                return response()->json(['data' => $package, 'status'=> 'error', 'message'=> 'Something went wrong. Please try again!']);
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
