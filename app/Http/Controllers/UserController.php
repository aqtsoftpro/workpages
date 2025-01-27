<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use App\Models\UserSocial;
use App\Models\{SiteSettings, Job, UserMeta};
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Events\SendDataToPusher;
use App\Mail\MultiPurposeEmail;
use App\Jobs\MultiPurposeEmailJob;
use App\Jobs\NotificationEmailJob;
use App\Models\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Events\UserRegisterEvent;
use App\Http\Resources\JobSeekerResource;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    public function index(User $user)
    {
        return response()->json($user->with('roles')->get());
    }

    public function show(User $user)
    {
        // $user->
        return response()->json($user->load('user_detail', 'documents', 'user_meta', 'location', 'designtion', 'qualification', 'job_location', 'reviews.company'));
    }

    public function store(User $user, Request $request)
    {
        $hased_passwoed = bcrypt($request->password);
        $request['password'] = $hased_passwoed;
        try {
            //Create user with hashed password
            $newUser = $user->create($request->all());

            // if(isset($request->photo)){
            //     if($request->photo != null){
            //         $fileExtension = $request->photo->getClientOriginalExtension();
            //         $uploadedPhoto =  $request->photo->storeAs('uploads/dp/', 'dp-' . $request->user_id . '.' . $fileExtension);
            //     }
            // }

            //Assign role to user
            $role = $request->role_id;
            $newUser->assignRole($role);

            $options = [
                'cluster' => 'ap2',
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options,
            );

            $data = ['from' => $newUser->id];

            $pusher->trigger('Rinzed', SendDataToPusher::class, $data);

            //send response with new user
            return response()->json([
                'status' => 'success',
                'user' => $newUser
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updatePassword($user_id, Request $request)
    {

        $hased_password = bcrypt($request->password);
        $userPassword = $hased_password;
        try {
            $id = auth()->id();
            User::where('id', $id)
                ->update([
                    'password' => $userPassword
                ]);
            return response()->json([
                'status' => 'user updated',
                'message' => 'Password updated successfully',
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(User $user, Request $request)
    {

        if (gettype($request->photo) != 'string' && $request->photo !== null) {
            $fileExtension = $request->photo->getClientOriginalExtension();
            $fileName = 'dp-' . $user->id . Str::random(2) . '.' . $fileExtension;
            $uploadedPhoto =  $request->photo->storeAs('public/', $fileName);
        }

        if ($request->hasFile('cv')) {
            $fileExtension = $request->cv->getClientOriginalExtension();
            $cvName = 'cv-' . $user->id . Str::random(2) . '.' . $fileExtension;
            $uploadCv =  $request->cv->storeAs('public/profile/cvs', $cvName);
        }

        $userRequest = $request->all();

        if (isset($uploadedPhoto)) {
            $userRequest['photo'] = env('APP_URL') . 'storage/' . $fileName;
        }

        if (isset($uploadCv)) {
            $userRequest['cv'] = env('APP_URL') . 'storage/profile/cvs' . $cvName;
        }


        if (isset($request->password)) {
            $hased_passwoed = bcrypt($request->password);
            $userRequest['password'] = $hased_passwoed;
        }

        // if (isset($request->casual_show)) {
        //     $userRequest['casual_show'] = 1;
        // } else {
        //     $userRequest['casual_show'] = 0;
        // }

        // if (isset($request->public_show)) {
        //     $userRequest['public_show'] = 1;
        // } else {
        //     $userRequest['public_show'] = 0;
        // }

        try {
            $user->update($userRequest);



            UserMeta::updateOrCreate([
                'user_id' => $user->id,
                'meta_key' => 'casual_show'
            ], [
                'meta_val' => $request?->casual_show == 'true' ? 1 : 0,
            ]);

            UserMeta::updateOrCreate([
                'user_id' => $user->id,
                'meta_key' => 'public_show'
            ], [
                'meta_val' => $request?->public_show == 'true' ? 1 : 0,
            ]);

            $jobs = Job::with('company.owner')->where(['location_id' => $user->current_job_location_id, 'qualification_id' => $user->qualification_id, 'status' => 'active', 'job_status' => 'live'])->get();
            if ($jobs->count() > 0) {
                $customBaseUrl = env('FRONT_APP_URL');
                $verificationUrl = rtrim($customBaseUrl) . 'job-seeker-list';
                $email_templates  = new EmailTemplateController();
                $get_template = $email_templates->get_template('new-jobseeker-register');
                $originalContent = $get_template['desc'];

                foreach ($jobs->take(4) as $job) {
                    $email_variables = [
                        '[username]' => $job->company?->owner?->name,
                        '[job_title]' => $job->job_title,
                        '[job_url]' => '<a href="' . rtrim($customBaseUrl) . 'job-details/' . $job->job_key . '/' . $job->job_slug . '" target="_blank">' . $job->job_title . '</a>',
                        '[profile_link]' => '<a href="' . rtrim($customBaseUrl) . 'job-seeker/' . $user->id . '" target="_blank">' . $user->name . '</a>',
                    ];

                    foreach ($email_variables as $search => $replace) {
                        $originalContent = str_replace($search, $replace, $originalContent);
                    };

                    $subject = "Work Pages- Almost there! New Jobseeker Registered";
                    $To = $job->company?->owner?->email;
                    $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
                    Mail::to($To)->send($email);
                }
            }

            $getUserMeta = UserMeta::where('user_id', $user->id)->get()->toArray();

            $userMeta = array();

            foreach($getUserMeta as $meta)
            {
                $userMeta[$meta['meta_key']] = $meta['meta_val'];
            }

            $user = User::where('id', $user->id)->with(['roles', 'user_detail', 'documents', 'company', 'subAccesses' => function ($query) {
                $query->whereDate('expired_at','>', now());
            }])->get();

            $user[0]['userMeta'] = $userMeta;


            return response()->json([
                'status' => 'user updated',
                'message' => 'Profile updated successfully',
                'user' => $user,
                'jobs' => $jobs,
            ]);


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 'user deleted'
        ]);
    }

    public function jobSeekerRegister(User $user, UserRegisterRequest $request)
    {
        // if($request['password'] != $request['confirm_password'])
        // {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => "Password didn't match to confirm password",
        //     ]);
        // }
        $hased_passwoed = bcrypt($request['password']);
        $request['password'] = $hased_passwoed;

        try {

            $email_exist = User::where('email', $request['email'])->first();

            if ($email_exist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already Exist!',
                ]);
            }

            if (gettype($request->photo) != 'string' && $request->photo !== null) {
                $fileExtension = $request->photo->getClientOriginalExtension();
                $fileName = 'dp-' . time() . '-' . rand(100000, 1000000) . '.' . $fileExtension;
                $uploadedPhoto =  $request->photo->storeAs('public/', $fileName);
            }

            if (isset($uploadedPhoto)) {
                $uploadedPhoto = env('APP_URL') . 'storage/' . $fileName;
            } else {
                $uploadedPhoto = null;
            }

            $newUser = User::create([
                'name' => $request['first_name'] . ' ' . $request['last_name'],
                'email' => $request['email'],
                'suburb_id' => $request['suburb_id'],
                'photo' => $uploadedPhoto,
                'password' => $request->password,
                'current_job_location_id' => $request->current_job_location_id ?? 2,
                'location_id' => $request->location_id ?? 2,
            ]);

            // broadcast(new UserRegisterEvent($newUser))->toOthers();

            if ($newUser) {
                $jobSeekerRole = Role::where('name', 'Job Seeker')->first();
                $newUser->assignRole($jobSeekerRole);
                $customBaseUrl = env('FRONT_APP_URL');
                $randomString = Str::random(40);
                $expired = now()->addMinutes(60);
                VerifyEmail::create([
                    'user_id' => $newUser->id,
                    'email' => $newUser->email,
                    'token' => Hash::make($randomString),
                    'expired_at' => $expired,
                ]);

                $verificationUrl = rtrim($customBaseUrl) . 'verify-email/?userId=' . $newUser->id . '&token=' . $randomString . '&expired=' . hash('sha256', $expired);

                $email_templates  = new EmailTemplateController();
                $get_template = $email_templates->get_template('job-seeker-verify-email');
                $originalContent = $get_template['desc'];

                $email_variables = [
                    '[username]' => $request->first_name . ' ' . $request->last_name,
                    // '[verify_email_link]' => '<a href="'.$verificationUrl.'" target="_blank">'.env('APP_URL').'</a>',
                ];

                foreach ($email_variables as $search => $replace) {
                    $originalContent = str_replace($search, $replace, $originalContent);
                };

                $subject = "Work Pages- Almost there! Verify your email address";
                $To = $request->email;
                $email = new MultiPurposeEmail($subject, $originalContent, $verificationUrl);
                Mail::to($To)->send($email);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful!',
                'user' => $newUser,
                'token' => $newUser->createToken($request->device_name)->plainTextToken
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchSeeker(Request $request)
    {
        $role = Role::where('name', 'Job Seeker')->first()->name;
        $company = Company::where('owner_id', auth()->id())->first();
        $user = User::query();


        $user->whereHas('user_meta', function ($query) {
            $query->where('meta_key', 'public_show')->where('meta_val', 1);
        });

        if ($request->has('filter')) {
            $filter = $request->filter;
            $user->where('name', 'LIKE', "%$filter%")
                ->orWhereHas('designtion', function ($q) use ($filter) {
                    $q->where('name', 'LIKE', "%$filter%");
                });
        }

        $user->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->doesntHave('company')
            ->where(function ($query) use ($company) {
                $query->where('location_id', $company->location_id)
                    ->orWhere('suburb_id', $company->suburb_id);
            });



        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();
        if ($request->pageId) {
            $offset = $request->pageId * $listing_rows_count['meta_val'];
        } else {
            $offset = 0;
        }

        $total_counts = $user->count();

        $seeker_listing = JobSeekerResource::collection(
            $user->offset($offset)
                ->limit($listing_rows_count['meta_val'])
                ->latest()->get()
        );
        $job_seekers  = array(
            'Listing' => $seeker_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );
        return response()->json($job_seekers);
    }



    public function getDirectory(Request $request)
    {
        $role = Role::where('name', 'Job Seeker')->first()->name;
        $company = Company::where('owner_id', auth()->id())->first();
        $user = User::query();


        $user->whereHas('user_meta', function ($query) {
            $query->where('meta_key', 'public_show')->where('meta_val', 1);
        });

        if ($request->has('filter')) {
            $filter = $request->filter;
            $user->where('name', 'LIKE', "%$filter%")
                ->orWhereHas('designtion', function ($q) use ($filter) {
                    $q->where('name', 'LIKE', "%$filter%");
                });
        }

        $user->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->doesntHave('company')
            ->where(function ($query) use ($company) {
                $query->where('location_id', $company->location_id)
                    ->orWhere('suburb_id', $company->suburb_id);
            });



        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();
        if ($request->pageId) {
            $offset = $request->pageId * $listing_rows_count['meta_val'];
        } else {
            $offset = 0;
        }

        $total_counts = $user->count();

        $seeker_listing = JobSeekerResource::collection(
            $user->offset($offset)
                ->limit($listing_rows_count['meta_val'])
                ->latest()->get()
        );
        $job_seekers  = array(
            'Listing' => $seeker_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );
        return response()->json($job_seekers);
    }





    public function updateUserSocial($user_id, Request $request): Response
    {

        // $inputs = $request->all();
        UserSocial::updateOrCreate(['user_id' => $user_id], $request->all());
        $user = User::with('socials')->findOrFail($user_id);
        return Response([
            'status' => 'success',
            'message' => 'Socials updated successfully',
            'data' => $user->socials,
        ]);
    }

    public function getUserSocial($user_id)
    {
        $userSocials = User::find($user_id)->socials;
        return response()->json($userSocials);
    }


    public function verifyEmail(Request $request)
    {
        $user = User::find($request->userId);
        $verifyMailData = VerifyEmail::where('user_id', $request->userId)->where('expired_at', '>=', now())->first();

        if ($user && $verifyMailData) {
            if (!Hash::check($request->token, $verifyMailData->token)) {
                return response()->json(['message' => 'Mismatch token'], 403);
            } else {
                $user->update([
                    'email_verified_at' => now(),
                ]);
                $verifyMailData->delete();
                return response()->json(['message' => 'Email verified successfully']);
            }
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }

    public function companyUsers(Request $request, User $users)
    {
        $company = Company::where('owner_id', auth()->id())->first()->id;
        $users = User::whereHas('applications', function ($query) use ($company) {
            $query->where('company_id', $company);
        });

        $listing_rows_count  = SiteSettings::select('meta_val')->where('meta_key', '_listing_rows_limit')->first();

        if ($request->pageId) {
            $offset = $request->pageId * $listing_rows_count['meta_val'];
        } else {
            $offset = 0;
        }

        $total_counts = $users->count();

        $seeker_listing = JobSeekerResource::collection(
            $users->offset($offset)
                ->limit($listing_rows_count['meta_val'])
                ->get()
        );
        $job_seekers  = array(
            'Listing' => $seeker_listing,
            'page_no' => $request->pageId,
            'count' => $total_counts,
            'showing_count' => $total_counts,
            'rows_count' =>  $listing_rows_count['meta_val'],
        );
        return response()->json($job_seekers);
    }

    public function getUser(User $user)
    {
        $user = $user->load(
            'location',
            'job_location',
            'designtion',
            'language',
            'qualification',
            'company',
            'applications',
            'UserMeta',
            'socials',
            'suburb',
            'documents',
            'user_detail'
        );
        return response()->json($user);
    }
}
