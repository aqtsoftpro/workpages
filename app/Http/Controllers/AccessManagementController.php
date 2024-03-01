<?php

namespace App\Http\Controllers;

use App\Models\SubAccess;
use Illuminate\Http\Request;

class AccessManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cvDownload()
    {
        try {
            $sub_access = SubAccess::where('user_id', auth()->id())->where('cv_credit', '>', 0)->whereDate('expired_at', '>', now())->first();
            $sub_access->update([
                'cv_credit' => $sub_access->cv_credit - 1
            ]);
            return response()->json(['status'=> 'success', 'message' => 'download success']);
        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error', 'message' => $th], 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubAccess $subAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubAccess $subAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubAccess $subAccess)
    {
        //
    }
}
