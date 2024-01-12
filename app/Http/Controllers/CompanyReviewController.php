<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyReview;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyReviewResource;
use App\Models\SiteSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CompanyReviewController extends Controller
{
    public function getCompanyReview($company_id){

        $companyReview = CompanyReview::where('company_id', $company_id)->get();

        $reviewCount = $companyReview->count();

        $reviews = array(
            'review' => CompanyReviewResource::collection($companyReview),
            'reviewCount' => $reviewCount,
        );

        return response()->json($reviews);

    }


    public function store(CompanyReview $companyreview, Request $request){
        try{



            $review = CompanyReview::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully!',
                'job' => $review
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

}

// echo $company_id;
// $companyReview = CompanyReview::where('company_id', $company_id)->get();

// print_r($companyReview);

// return response()->json(new CompanyReviewResource($companyReview));