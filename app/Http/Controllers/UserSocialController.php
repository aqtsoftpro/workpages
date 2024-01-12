<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserSocial;
use Illuminate\Http\Request;

class UserSocialController extends Controller
{
    public function index(UserSocial $userSocial){
        return response()->json($userSocial::all());
    }

    public function show(UserSocial $userSocial){
        return response()->json($userSocial)->socials;
    }

    public function store(UserSocial $userSocial, Request $request){
        try{
            $newSocial = $userSocial->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'User Social Created!',
                'user' => $newSocial
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(UserSocial $userSocial, Request $request){
        try{

            if(UserSocial::where('user_id', $request->user_id)->count() == 0){
                $userSocial->create($request->all());
                $social = UserSocial::where('user_id', $request->user_id)->first();
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Created Updated!',
                    'user_social' => $userSocial
                ]);
            } else{
                $userSocial = UserSocial::where('user_id', $request->user_id)->first();
                $userSocial->update($request->all());
                $social = UserSocial::where('user_id', $request->user_id)->first();
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Social Updated!',
                    'user_social' => $social
                ]);
            }
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(UserSocial $userSocial){
        $userSocial->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User Social Deleted!'
        ]);
    }
}
