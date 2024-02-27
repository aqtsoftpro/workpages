<?php

namespace App\Http\Controllers;

use App\Models\{UserDetail, Document};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserDetailController extends Controller
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
        $inputs['user_id'] = auth()->id();
        $user_detail = UserDetail::where('user_id', auth()->id())->firstOrNew();
        if ($request->hasFile('intro_video')) {
            $image = $request->file('intro_video')->store('profile/intro', 'public');
            $inputs['intro_video'] = env('APP_URL') . 'storage/' . $image;        
            if ($user_detail->intro_video) {
                $introVideoPath = Str::after($user_detail->intro_video, '/storage');
                if (Storage::disk('public')->exists($introVideoPath)) {
                    Storage::disk('public')->delete($introVideoPath);
                }
            }
        }        
        $user_detail->update($inputs);
        return response()->json([
            'status' => 'success',
            'message' => 'User detail updated successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function getDetail()
    {
        $user_detail = UserDetail::where('user_id', auth()->id())->first();
        $documents = Document::where('user_id', auth()->id())->get();
        return Response(['user_detail'=>$user_detail, 'documents'=>$documents]);
    }

    public function storeDocs(Request $request)
    {
        if ($request->hasFile('file_path')) {
            $inputs = $request->all();
            $inputs['user_id'] = auth()->id();
            $image = $request->file('file_path')->store('profile/docs', 'public');
            $inputs['file_path'] = env('APP_URL') . 'storage/' . $image;
            Document::create($inputs);
            return response()->json([
                'status' => 'success',
                'message' => 'document uplaoded successfully',
            ]);        
        } 
    }

    public function updateStatus(Request $request)
    {
        $user_detail = UserDetail::where('user_id', auth()->id())->first();
        $inputs = [];
        if ($request->profile_status) {
            $inputs['profile_status'] = $request->profile_status;
        }
        if ($request->is_available) {
            $inputs['is_available'] = $request->is_available;
        }
        if ($user_detail && !empty($inputs)) {
            $user_detail->update($inputs);
            $documents = Document::where('user_id', auth()->id())->get();
            return Response([
                'status' => 'success',
                'message' => 'status updated successfully',
                'user_detail'=>$user_detail, 
                'documents'=>$documents
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserDetail $user_detail)
    {
        $user_detail->update($request->all());
        return Response([
                'status' => 'success',
                'message' => 'User detail updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDetail $userDetail)
    {
        //
    }
}
