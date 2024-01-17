<?php

namespace App\Http\Controllers;

use App\Models\{Package, Subscription};
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
        try {
                // Create the product
                $product = \Stripe\Product::create([
                    'name' => $request->name,
                    'type' => 'service', // optional field
                    'description' => "this is jsut test", // optional field
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

                    }
                }

            $added_rec = Package::create($inputs);

            if($added_rec)
            {
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
            //dd($ex->getMessage());
            return redirect()->route('admin.plans.index')->with('failed', $ex->getMessage());
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
