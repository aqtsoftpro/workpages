<?php

use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\AdminCmsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserMetaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserSocialController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyTypeController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobPostedOnController;
use App\Http\Controllers\SalaryRangeController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CompanyReviewController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GlobalVariableController;
use App\Http\Controllers\LocationStatesController;
use App\Http\Controllers\SuburbController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ApiVerifyEmailController;
// use App\Http\Controllers\Auth\VerifyEmailController;

// VerifyEmailController




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/workpages/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials are incorrect'
        ]);
    }

    $response = [
        'status' => 'success',
        'token' => $user->createToken($request->device_name)->plainTextToken
    ];

    return $response;
});

Route::post('/workpages/getUser', function (Request $request) {
    $tokenString = $request->token;
    $token = PersonalAccessToken::findToken($tokenString);
    $user =  $token->tokenable;

    $getUserMeta = UserMeta::where('user_id', $user->id)->get()->toArray();

    $userMeta = array();
    foreach($getUserMeta as $meta)
    {
        $userMeta[$meta['meta_key']] = $meta['meta_val'];
    }

    $getUserInfo = $user->where('id', $user->id)->with('roles', 'company')->get();

    $getUserInfo[0]['userMeta'] = $userMeta;

    return $getUserInfo;
    //return User::find($user->id)->with('roles')->first();
    //return new UserResource($token->tokenable);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('verify-email/', ApiVerifyEmailController::class);
    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::put('updatePassword/{user_id}', [UserController::class, 'updatePassword']);
    Route::resource('user', UserController::class);
    Route::put('updateUserMeta/{user_id}', [UserMetaController::class, 'updateUserMeta']);
    Route::get('getUserMeta/{user_id}', [UserMetaController::class, 'updateUserMeta']);
    Route::put('updateUserSocial/{user_id}', [UserController::class, 'updateUserSocial']);
    Route::get('getUserSocial/{user_id}', [UserController::class, 'getUserSocial']);
    Route::resource('designation', DesignationController::class);
    Route::resource('qualification', QualificationController::class);
    Route::resource('location', LocationController::class);
    Route::resource('language', LanguageController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('companyType', CompanyTypeController::class);
    //Route::post('updateCompanyProfile', [CompanyController::class, 'updateCompanyProfile']);
    Route::post('updateCompanyProfile/{id}', [CompanyController::class, 'updateCompanyProfile']);
    Route::resource('job', JobController::class);

    Route::resource('application', ApplicationController::class);
    Route::put('updateCandidateApplication', [ApplicationController::class, 'updateCandidateApplication']);
    Route::put('deleteCandidateApplication', [ApplicationController::class, 'destroy']);

    Route::resource('jobType', JobTypeController::class);
    Route::resource('userSocial', UserSocialController::class);

    Route::post('stripe/checkout', [PackageController::class, 'session']);

    Route::post('zeroSubscribe', [PackageController::class, 'zeroPlan']);

    Route::get('companySubscriptions', [PackageController::class, 'subPlans']);

    Route::post('updateUserPortfolio/{id?}', [PortfolioController::class, 'updateUserPortfolio']);
    
});

Route::middleware('cors')->group(function(){
    
    Route::get('stripe/success/{id}/{session}/{user}', [PackageController::class, 'success']);

    Route::get('getUserPortfolio/{id}', [PortfolioController::class, 'getUserPortfolio']);

    Route::post('delete-portfolio/{portfolio}', [PortfolioController::class, 'destroy']);

    Route::get('updateCompanyProfile/{id}', [CompanyController::class, 'updateCompanyProfile']);

    Route::get('globalVariables', [GlobalVariableController::class, 'index']);
    Route::get('homeStats', [StatsController::class, 'homeStats']);

    Route::post('getCandidateAppiedOnJob/{user_id}/{job_id}', [ApplicationController::class, 'CandidateAppiedOnJob']);

    Route::get('subrubs', [SuburbController::class, 'subrubs_list']);

    Route::post('jobSeekerRegister', [UserController::class, 'jobSeekerRegister']);
    Route::post('company_register', [CompanyController::class, 'CompanyRegister']);
    Route::get('companies', [CompanyController::class, 'companies']);
    Route::get('CompaniesListing', [CompanyController::class, 'CompaniesListing']);
    Route::get('categories', [CategoryController::class, 'categories']);
    Route::get('trending_jobs_categories', [CategoryController::class, 'trending_jobs_categories']);

    Route::get('filter_type_of_employments', [JobTypeController::class, 'filter_type_of_employments']);
    Route::get('filter_salary_range', [SalaryRangeController::class, 'filter_salary_range']);
    Route::get('filter_job_posted_on', [JobPostedOnController::class, 'filter_job_posted_on']);

    Route::get('filter_companies_location', [LocationController::class, 'filter_companies_location']);
    Route::get('location', [LocationController::class, 'locations']);
    Route::get('states', [LocationStatesController::class, 'states']);

    Route::get('filter_company_type', [CompanyTypeController::class, 'filter_company_type']);
    Route::get('companyTypes', [CompanyTypeController::class, 'index']);

    Route::get('jobsListing', [JobController::class, 'JobsListing']);
    Route::get('filteredJobs', [JobController::class, 'FilteredJobs']);
    Route::get('latestJobs', [JobController::class, 'latestJobs']);
    Route::get('featuredJobs', [JobController::class, 'featuredJobs']);
    Route::get('jobs', [JobController::class, 'index']);
    Route::get('testimonials', [TestimonialController::class, 'testimonials']);
    Route::post('jobDetail/{job_key}', [JobController::class, 'jobDetail']);
    Route::get('categoryJobs/{cat_slug}', [JobController::class, 'categoryJobs']);

    Route::get('getCompanyByUserId/{user_id}', [CompanyController::class, 'getCompanyByUserId']);

    Route::get('jobTypes', [JobTypeController::class, 'index']);
    Route::get('qualifications', [QualificationController::class, 'index']);
    Route::post('search_jobs', [JobController::class, 'search_jobs']);
    Route::post('getJobs/{comapny_id}', [JobController::class, 'companyJobs']);
    Route::get('getApplicationsByUserId/{user_id}', [ApplicationController::class, 'getApplicationsByUserId']);
    Route::get('getApplicationsByCompany', [ApplicationController::class, 'getApplicationsByCompany']);
    Route::post('getCompanyInfo/{company_id}', [CompanyController::class, 'getCompanyInfo']);

    Route::get('getCompanyReviews/{company_id}', [CompanyReviewController::class, 'getCompanyReview']);
    Route::resource('companyReviews', CompanyReviewController::class);

    Route::get('getCompanyJobs', [JobController::class, 'getCompanyJobs']);
    Route::post('updateJobStatus', [JobController::class, 'updateJobStatus']);
    Route::put('updateJob/{id}', [JobController::class, 'update']);


    Route::post('emails/contactUs/', [EmailsController::class, 'contact_us']);
    Route::get('emails/contactUs/', [EmailsController::class, 'contact_us']);
    // Route::put('updateJob/{id}', JobController::class);
    Route::post('password/email', [ForgotPasswordController::class, 'forgot']);
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'getToken']);
    Route::post('password/reset', [ForgotPasswordController::class, 'reset']);
    Route::post('newletterEmail/', [NewsletterController::class, 'mailChimpEmailLog']);
    Route::post('storePartner/', [NewsletterController::class, 'CharityPost']);
    // Show all packages....
    Route::get('packages', [PackageController::class, 'index']);
 });

Route::get('cmsPages/', [AdminCmsController::class, 'get_page']);












// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
