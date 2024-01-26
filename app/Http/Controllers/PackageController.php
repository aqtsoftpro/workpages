<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Laravel\Cashier\Cashier;
use App\Models\{Subscription, Company};

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('keypoints')->get();
        // return response()->json(PackageResource::collection(Package::all()));
        return response()->json($packages);
    }

    //just check if it works or not
    public function session(Request $request){

        $package = Package::find($request->package);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $externalUrl = env('FRONT_APP_URL').'/company/plan';

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price'      => $package->stripe_price_id, // Replace with the ID of the price/plan you want to subscribe to
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'subscription',
            'success_url' => url('api/stripe/success/'.encrypt($package->id).'/{CHECKOUT_SESSION_ID}'.'/'.auth()->id()),
            'cancel_url'  => $externalUrl,            
        ]);

        return response()->json($session);

        // return redirect()->away($session->url);
    }

    public function success($id, $session_id, $user){

        \Log::info('Success URL triggered:', [
            'encryptedId' => $id,
            'checkoutSessionId' => $session_id,
            'userId' => $user,
        ]);
        
        $package = Package::find(decrypt($id));
        $company = Company::where('owner_id', $user)->first();
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

        $subscription = Subscription::where('stripe_id', $payment_intent->data[0]['id'])->first();

        if (!$subscription) {
            Subscription::create([
                'user_id' => $user,
                'package_id'=> $package->id,
                'company_id' => $company->id,
                'name' => $package->name,
                'stripe_id' => $payment_intent->data[0]['id'],
                'stripe_price' => $package->price,
                'quantity' => 1,
                'stripe_status' => 'active',
            ]);
        }

        $externalUrl = env('FRONT_APP_URL').'company/plan';

        return redirect()->away($externalUrl);

    }
    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
