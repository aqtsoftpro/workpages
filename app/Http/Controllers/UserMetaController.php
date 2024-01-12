<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserMeta;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserMetaController extends Controller
{

    public function updateUserMeta($user_id, Request $request)
        {


            // return response()->json($request->all());
            foreach ($request->all() as $key => $val) {
                UserMeta::updateOrInsert(
                    [
                        'meta_key' => $key,
                        'user_id' => $user_id,
                    ],
                    ['meta_val' =>  $val]                
                );
            }

            $getUserMeta = UserMeta::where('user_id', $user_id)->get()->toArray();

            $userMeta = array();
            foreach($getUserMeta as $meta)
            {
                $userMeta[$meta['meta_key']] = $meta['meta_val'];
            }
        
            $getUserInfo = User::where('id', $user_id)->with('roles', 'company')->get();
        
            $getUserInfo[0]['userMeta'] = $userMeta;

            return response()->json([
                'status' => 'user updated',
                'message' => 'User Setting Updated!',
                'user' => $getUserInfo,
            ]);
        }

}
