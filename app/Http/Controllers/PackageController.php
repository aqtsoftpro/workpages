<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use Illuminate\Http\Response;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Laravel\Cashier\Cashier;
use App\Models\{Subscription, Company, Cms, SubAccess};
use Carbon\Carbon;

class PackageController extends Controller
{
    public function index()
    {
        $packages = PackageResource::collection(Package::with('keypoints')->orderBy('price', 'asc')->get());
        // return response()->json(PackageResource::collection(Package::all()));
        return response()->json($packages);
    }

    //just check if it works or not
    public function session(Request $request){

        $package = Package::find($request->package);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $externalUrl = env('FRONT_APP_URL').'company/plan';

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

        // dd($payment_intent->data[0]['charges']['data'][0]['payment_method_details']['card']);

        $card_data = $payment_intent->data[0]['charges']['data'][0]['payment_method_details']['card'];
        // dd($payment_intent->data[0]['charges']['data'][0]['receipt_url']);
        $receipt = $payment_intent->data[0]['charges']['data'][0]['receipt_url'];
        $subscription = Subscription::where('stripe_id', $payment_intent->data[0]['id'])->first();
        // dd($package);

        if (!$subscription) {
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
            $subscription = Subscription::create([
                'user_id' => $user,
                'package_id'=> $package->id,
                'company_id' => $company->id ?? null,
                'name' => $package->name,
                'stripe_id' => $payment_intent->data[0]['id'],
                'stripe_price' => $package->price,
                'quantity' => 1,
                'ends_at' => $expire,
                'stripe_status' => 'active',
                'last_4' => $card_data['last4'],
                'brand' => $card_data['brand'],
                'exp_month' => $card_data['exp_month'],
                'exp_year' => $card_data['exp_year'],
                'receipt_url' => $receipt,
            ]);
            if ($subscription) {
                $sub_access = SubAccess::create([
                    'user_id' => $user,
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
                    'rec_support' => $package->rec_support,
                    'cv_credit' => $package->cv_credit,
                    'msg_credit' => $package->msg_credit,
                    'cv_access' => $package->cv_access,
                    'expired_at' => $expire,
                ]);

            }
        }

        $externalUrl = env('FRONT_APP_URL').'company/plan';
        return redirect()->away($externalUrl);
    }
    /**
     * Display the specified resource.
     */
    public function zeroPlan(Request $request)
    {
        $package = Package::findOrFail($request->package);
        $subscription = Subscription::where('package_id', $request->package)->first();
        if ($subscription) {
            return response()->json([
                'status' => 'successs',
                'data' => $subscription,
                'message' => 'You have already subcribed this plan',
            ]);
        } else {
            if ($package->price == 0 || $package->price == 0.00 ||  $package->price == null || $package->price == "") {
                $inputs = $request->all();
                $intervalCount = $package->interval_count;
                $currentDateTime = Carbon::now();

                switch ($package->interval) {
                    case 'day':
                        $newDateTime = $currentDateTime->addDays($intervalCount);
                        break;
                    case 'month':
                        $newDateTime = $currentDateTime->addMonths($intervalCount);
                        break;
                    case 'year':
                        $newDateTime = $currentDateTime->addYears($intervalCount);
                        break;
                    default:
                        $newDateTime = $currentDateTime->addDays($intervalCount);
                        break;
                }
                $auth = auth()->user();
                $company = Company::where('owner_id', $auth->id)->first();
                // $company?->id ?? null;
                $inputs['user_id'] = $auth->id;
                $inputs['package_id'] = $package->id;
                $inputs['company_id'] = $company?->id ?? null;
                $inputs['name'] = $package->name;
                $inputs['quantity'] = 1;
                // $inputs['stripe_id'] = 'zero';
                // $inputs['stripe_status'] = 'no';
                // $inputs['stripe_price'] = $package->price;
                $inputs['quantity'] = 1;
                $inputs['trial_ends_at'] = $newDateTime;
                $inputs['ends_at'] = $newDateTime;
                $subscription = Subscription::create($inputs);
                if ($subscription) {
                    return response()->json([
                        'status' => 'successs',
                        'data' => $subscription,
                        'message' => 'You have successfully subcribed',
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Some thing went wrong...',
                    ]);
                }
            }  
        }    
    }

    /**
     * Update the specified resource in storage.
     */
    public function subPlans(): Response
    {
        $company = Company::where('owner_id', auth()->id())->first();
        if ($company) {
            $subscription = Subscription::with('package')->where('company_id', $company->id)->get();
            return Response($subscription);
        }
        else {
            return Response($subscription);
        }
    }

    public function get_page(Request $request)
    {
        $page_content = Cms::where('slug', $request->page_slug)->first();
        return response()->json($page_content->desc);
    }

    public function getPage(Request $request)
    {
        $page_content = Cms::where('slug', $request->page_slug)->first();
        return response()->json($page_content->desc ?? null);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function unSub(Request $request)
    {
        $subscription = Subscription::find($request->subscription_id);
        if ($subscription) {
            $accesses = SubAccess::where('subscription_id', $subscription->id)->first();
            $accesses->delete();
            $subscription->delete();
        }
        return response()->json(['status' => 'successs', 'data' => [], 'message' => 'successfully unsubcribed',]);
    }
}
