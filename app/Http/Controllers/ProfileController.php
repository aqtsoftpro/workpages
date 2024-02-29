<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // dd($request->all());
        if ($request->hasFile('admin_img') && $request->file('admin_img')->isValid()) {

            $FileName = $request->file('admin_img')->store('/','public');
            $filePath = Storage::url($FileName);
            $user = User::find($request->id);
            $user->update([
                'photo' => env('APP_URL').ltrim($filePath, '/'),
            ]);
            // dd($user);
        }

        if($request->admin_name)
        {
            User::where('id', '=', $request->id)->update([
                'name' => $request->admin_name,
            ]);  
        }

        if($request->password)
        {
            $user = User::where('email', $request->admin_email)->first();
    
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('error', 'Enter current correct password!');
            }
        }
        
        if($request->new_password)
        {
            User::where('id', '=', $request->id)->update([
                'password' => Hash::make($request->new_password) 
            ]);
        }
   
        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
