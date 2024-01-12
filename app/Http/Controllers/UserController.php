<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\UserSocial;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(User $user){
        return response()->json($user->with('roles')->get());
    }

    public function show(User $user){
        return response()->json($user);
    }

    public function store(User $user, Request $request){
        $hased_passwoed = bcrypt($request->password);
        $request['password'] = $hased_passwoed;
        try{
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

            //send response with new user
            return response()->json([
                'status' => 'success',
                'user' => $newUser
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function updatePassword($user_id, Request $request)
    {

        $hased_password = bcrypt($request->password);
        $userPassword = $hased_password;


        try{
            User::where('id', $user_id)
            ->update([
                'password' => $userPassword
                ]);
            return response()->json([
                'status' => 'user updated',
                'message' => 'Password updated successfully',
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(User $user, Request $request){

        if(gettype($request->photo) != 'string' && $request->photo !== null){
            $fileExtension = $request->photo->getClientOriginalExtension();
            $fileName = 'dp-' . $user->id . '.' . $fileExtension;
            $uploadedPhoto =  $request->photo->storeAs('public/', $fileName);
        }

        $userRequest = $request->all();

        if(isset($uploadedPhoto)){
            $userRequest['photo'] = env('APP_URL') . '/storage/' . $fileName;
        }

        if(isset($request->password)){
            $hased_passwoed = bcrypt($request->password);
            $userRequest['password'] = $hased_passwoed;
        }

        try{

            $user->update($userRequest);
            return response()->json([
                'status' => 'user updated',
                'message' => 'Profile updated successfully',
                'user' => User::where('id', $user->id)->with('roles')->get()
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(User $user){
        $user->delete();
        return response()->json([
            'status' => 'user deleted'
        ]);
    }

    public function jobSeekerRegister(User $user, Request $request)
    {
        $hased_passwoed = bcrypt($request['password']);
        $request['password'] = $hased_passwoed;

        try{

            $email_exist = User::where('email', $request['email'])->first();

            if($email_exist)
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already Exist!',
                ]);
            }

            if(gettype($request->photo) != 'string' && $request->photo !== null){
                $fileExtension = $request->photo->getClientOriginalExtension();
                $fileName = 'dp-' . time().'-'.rand(100000,1000000) . '.' . $fileExtension;
                $uploadedPhoto =  $request->photo->storeAs('public/', $fileName);
            }

            if(isset($uploadedPhoto)){
                $uploadedPhoto = env('APP_URL') . '/storage/' . $fileName;
            }
            else
            {
                $uploadedPhoto = '';
            }

            // if(isset($request['photo'])){
            //     if($request['photo'] != null){
            //         $fileName = time().'-'.rand(100000,1000000).'.'.$request->photo->getClientOriginalExtension();

            //         $uploadedPhoto =  $request->photo->storeAs('dp', $fileName);
            //     }
            //     else
            //     {
            //         $uploadedPhoto = '';
            //     }

            // }

            $newUser = $user->create([
                'name' => $request['first_name'] . ' ' . $request['last_name'],
                'email' => $request['email'],
                'suburb_id' => $request['suburb_id'],
                'photo' => $uploadedPhoto,
                'password' => $request->password
            ]);

            //Assign Job Seeker role to user
            $jobSeekerRole = Role::find(2);
            $newUser->assignRole($jobSeekerRole);

            // if(isset($request['data']['company_name'])){
            //     //Assign Employer role to user
            //     $employerRole = Role::find(3);
            //     $newUser->assignRole($employerRole);

            //     Company::create([
            //         'name' => $request['company_name'],
            //         'owner' => $newUser->id,
            //         'package_id' => 1,
            //         'company_type_id' => $request['company_type_id']
            //     ]);
            // } else {;
            //     //Assign Job Seeker role to user
            //     $jobSeekerRole = Role::find(2);
            //     $newUser->assignRole($jobSeekerRole);
            // }

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful!',
                'user' => $newUser
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }


    public function updateUserSocial($user_id, Request $request){
        if(isset(User::find($user_id)->socials)){
            User::find($user_id)->socials->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Socials updated successfully',
                'data' => User::find($user_id)->socials
            ]);
        } else {
            UserSocial::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Socials created successfully',
                'data' => User::find($user_id)->socials
            ]);
        }
    }

    public function getUserSocial($user_id){
        $userSocials = User::find($user_id)->socials;
        return response()->json($userSocials);
    }
}
