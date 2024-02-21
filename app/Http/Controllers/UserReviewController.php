<?php

namespace App\Http\Controllers;

use App\Models\{UserReview, Company};
use Illuminate\Http\Request;

class UserReviewController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        try {
            $company = Company::where('owner_id', auth()->id())->first()->id;
            $inputs['company_id'] = $company;
            $review = UserReview::where(['user_id' => $request->user_id, 'company_id' => $company])->first();
            if (!$review) {
                UserReview::create($inputs);
                return response()->json(['status'=>'success', 'message' => 'review submitted successfully']);
            } else {
                return response()->json(['status'=>'error', 'message' => 'You already submitted a review']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>'error', 'message' => $th]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserReview $userReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReview $userReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReview $userReview)
    {
        //
    }
}
