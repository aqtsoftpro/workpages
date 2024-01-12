<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Suburb;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Models\SiteSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\EmailTemplateController;

class CompanyController extends Controller
{
    public function index(Request $request)
    {

        if(isset($request->suburb_id))
        {
            $records = Company::orderBy('name', 'ASC')->where('suburb_id', $request->suburb_id)->get();
            $get_suburb_id = $request->suburb_id;
        }
        else
        {
            $records = Company::orderBy('name', 'ASC')->get();
            $get_suburb_id = '';
        }

        $suburbs = Suburb::get();

        return view('admin.companies.index', compact('records', 'suburbs', 'get_suburb_id'));

    }

    public function edit(string $id)
    {
        // $record = JobSeeker::find($id);

        $record = DB::table('users')
        ->select('companies.name AS company_name', 'users.*')
        ->where('users.id', $id)
        ->join('companies', 'companies.owner', '=', 'users.id')
        ->first();
   
        return view('admin.companies.edit', compact('record'));
    }

    public function show(string $id)
    {
        $record = Company::find($id);

        return view('admin.companies.show', compact('record'));
    }


    public function destroy(string $id)
    {
        
        $deleted_rec = User::find($id);

        if(User::destroy($id)) {

            return redirect()->route('companies.index')
                        ->with('success',''.$deleted_rec->name.' company deleted successfully');
          } else {
            return redirect()->route('companies.index')
                        ->with('error','Please try again!');
        }
    }

    public function companies(Company $company){

        return response()->json(CompanyResource::collection($company->limit(10)->get()));
    }


    public function updateCompanyProfile(Company $company, Request $request, $id)
    {
        $company_id = $id;

        // return response()->json([
        //     'testCompResponse' => $request->all(),
        // ]);

        $uploadedLogo = null;
        $uploadedCoverPhoto = null;

        if(gettype($request->logo) != 'string' && $request->logo !== null){
            $logoFileName = 'logo-' . $request->id . '.' . $request->logo->extension();
            $request->file('logo')->storeAs('public', $logoFileName);
        }

        if(gettype($request->cover_photo) !== 'string' && $request->cover_photo !== null){
            $coverPhotoFileName = 'coverphoto-' . $request->id . '.' . $request->cover_photo->extension();
            $request->file('cover_photo')->storeAs('public', $coverPhotoFileName);
        }

        $requestData = array(
            'name' => $request->name,
            'company_type_id' => $request->company_type_id,
            'company_size' => $request->company_size,
            'location_id' => $request->location_id,
            'state_id' => $request->state_id,
            'address' => $request->address,
            'weblink' => $request->weblink,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'pinterest' => $request->pinterest,
            'dribble' => $request->dribble,
            'behance' => $request->behance,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        );


        if(isset($logoFileName)){
            $requestData['logo'] = env('APP_URL') . '/storage/' . $logoFileName;
        }
        if(isset($coverPhotoFileName)){
            $requestData['cover_photo'] = env('APP_URL') . '/storage/' . $coverPhotoFileName;
        }
        

        try{

            Company::where('id', $company_id)->update($requestData);

            $companyInfo = Company::find($company_id);

   
            return response()->json([
                'status' => 'success',
                'message' => 'Company updated!',
                'company' => $companyInfo
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }

    }

    // public function show(Company $company){
    //     return response()->json(new CompanyResource($company));
    // }

    // public function store(Company $company, Request $request){
    //     try{
    //         $company->create($request->all());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Company created!',
    //             'company' => $company
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function update(Company $company, Request $request){

    //     $uploadedLogo = null;
    //     $uploadedCoverPhoto = null;


    //     if(gettype($request->logo) != 'string' && $request->logo !== null){
    //         $logoFileName = 'logo-' . $request->id . '.' . $request->logo->extension();
    //         $request->file('logo')->storeAs('public', $logoFileName);
    //     }


    //     if(gettype($request->cover_photo) !== 'string' && $request->cover_photo !== null){
    //         $coverPhotoFileName = 'coverphoto-' . $request->id . '.' . $request->cover_photo->extension();
    //         $request->file('cover_photo')->storeAs('public', $coverPhotoFileName);
    //     }

    //     $requestData = $request->all();

    //     if(isset($logoFileName)){
    //         $requestData['logo'] = env('APP_URL') . '/storage/' . $logoFileName;
    //     }
    //     if(isset($coverPhotoFileName)){
    //         $requestData['cover_photo'] = env('APP_URL') . '/storage/' . $coverPhotoFileName;
    //     }

    //     try{
    //         $company->update($requestData);
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Company updated!',
    //             'company' => $company
    //         ]);
    //     }   catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function destroy(Company $company){
    //     $company->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Company deleted!'
    //     ]);
    // }

    public function getCompanyByUserId($user_id){
      
        $user = User::find($user_id);

        $company_resource = new CompanyResource($user->company);
        $company_resource->email = $user->email;
        // print_r($company_resource);
        return new CompanyResource($company_resource);
        //return response()->json(new CompanyResource($company_resource));
    }

    public function getCompanyInfo($company_id){

        $company = Company::find($company_id);


        return response()->json(new CompanyResource($company));
    }

        public function CompanyRegister(Company $company, Request $request)
        {
            
            $hased_password = bcrypt($request->password);
            $request['password'] = $hased_password;

            try{
    
                $email_exist = User::where('email', $request['email'])->first();
    
                if($email_exist)
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email Already Exist!',
                    ]);
                } 
                
                $user = new User();

                $verificationToken = md5(uniqid(rand(), true));
    
                $newUser = $user->create([
                    'name' => $request->first_name.' '.$request->last_name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'suburb_id' => $request->suburb_id,
                    'email_verified_at' => $verificationToken
                ]);
    
                if($newUser)
                {
                    //Assign Employer role to user
                    $employerRole = Role::find(3);
                    $newUser->assignRole($employerRole);
    
                    Company::create([
                        'name' => $request->company_name,
                        'owner_id' => $newUser->id,
                        'package_id' => 1,
                        'company_type_id' => $request->company_type_id,
                        'suburb_id' => $request->suburb_id
                        
                    ]);

                    $email_templates  = new EmailTemplateController();
                    $get_template = $email_templates->get_template('company-account-verify');
                    $originalContent = $get_template['desc'];

                    // email=' . urlencode($userEmail) . '&token=' . $verificationToken;

                    $email_variables = [
                        '[Name]' => $request->first_name.' '.$request->last_name,
                        '[Account Verify Link]' => '<a href="'.env('FRONT_APP_URL').'account-verification/?email='. urlencode($request->email) .'&token='.$verificationToken.'" target="_blank">'.env('FRONT_APP_URL').'</a>',
                    ];

                    echo $originalContent;

                    foreach ($email_variables as $search => $replace) {
                        $originalContent = str_replace($search, $replace, $originalContent);
                    };

                    $subject = "Account verification Email";
                    $To = $request->email;

                    echo $originalContent;

                    //$result = Mail::to($To)->send(new MultiPurposeEmail($subject, $originalContent));


                }
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Registration successful!',
                    'user' => $newUser
                ]);

            }   
                catch(Exception $e)
            {

                return $e->getMessage();
            }
        }


    public function CompaniesListing(Request $request, Company $company){

        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();

        $q = $company->newQuery();

        if($request->pageId)
        {
            $offset = $request->pageId*$listing_rows_count['meta_val'];
        }
        else
        {
            $offset = 0;
        }

        if(!empty($request->companyTypes)){
            $q->whereIn('company_type_id', explode(",", $request->companyTypes));
        }

        if(!empty($request->companyLocations)){
            $q->whereIn('location_id', explode(",", $request->companyLocations));
        }

        $total_counts = $q->count();

        $companies_listing = 
        CompanyResource::collection(
            $q->offset($offset)
            ->limit($listing_rows_count['meta_val'])
            ->get()
        );

        $all_companies  = array(
            'Listing' => $companies_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );

        return response()->json($all_companies);
    }
}
