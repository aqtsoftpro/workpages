<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class AdminUsersController extends Controller
{
    public function index(){
        $this->authorize('viewAny', User::class);
        $job_seekers =  User::all();

        // if (auth()->user()->roles('Super Admin')) {
        //     $job_seekers =  User::all();
        // }
        // else {
        //     $job_seekers =  Role::where('name', 'Super Admin')->first()->users;
        // }
        return view('admin.users.index', compact('job_seekers'));
    }

    public function companies() {
        $this->authorize('viewAny', User::class);
        $employers =  Role::find(3)->users()->with('company')->get();
        return view('admin.users.companies', compact('employers'));
    }

    public function admin_users() {
        // $this->authorize('viewAny', Role::class);
        // $roles =  Role::get()->toArray();
        // $admin_user = array();
        // foreach($roles as $role)
        // {

        //     if($role['name'] == 'Super Admin' || $role['name'] == 'Job Seeker' || $role['name'] == 'Employer')
        //     {
        //         continue;
        //     }

        //     $records =  Role::find($role['id'])->users;
        // }

        $role = Role::where('name', 'Super Admin')->first();

        $records = $role->users;

        return view('admin.users.admin_user', compact('records'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Role::get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {

        $this->authorize('create', User::class);
        $hased_passwoed = bcrypt($request['password']);
        $request['password'] = $hased_passwoed;



        $email_exist = User::where('email', $request['email'])->first();

            if($email_exist)
            {
                return redirect()->route('users.create')
                ->with('success',''.$request->name.' already exist successfully.');
            }


        $newUser = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            // 'photo' => $uploadedPhoto,
            'password' => $request->password
        ]);

        if($request->role)
        {
            foreach($request->role as $role)
            {
                $adminUserRole = Role::find($role);

                $user = User::find($newUser->id);

                $user->assignRole($adminUserRole);
            }
        }


        if($newUser)
        {
            return redirect()->route('admin_users')
                        ->with('success',''.$request->name.' user added successfully.');
        }
        else
        {
            return redirect()->route('admin_users')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit(User $user)
    {
        $this->authorize('create', User::class);

        $record = $user;

        $user_roles = Role::get();

        $user = $user;

        return view('admin.users.edit', compact('record', 'user_roles'));
    }

    public function update(Request $request, User $user)
    {

        $update_user = $user;

        if($request['password'] != '')
        {
            $hased_passwoed = bcrypt($request['password']);
            $request['password'] = $hased_passwoed;

            $update_user->update([
                'name' => $request['name'],
                'password' => $request->password,
                'email_verified_at' => $request->email_verified_at,
            ]);
        }
        else
        {
            $update_user->update([
                'name' => $request['name'],
                'email_verified_at' => $request->email_verified_at,
            ]);
        }

        if($request->role)
        {
            foreach($request->role as $role)
            {
                $adminUserRole = Role::find($role);

                $user = User::find($user->id);

                $user->syncRoles($adminUserRole);
            }
        }

        if($update_user)
            {
                return redirect()->back()->with('success', ''.$request->name.' user updated successfully');
            }
            else
            {
                return redirect()->back()->with('danger', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(User $user)
    {
        $deleted_rec = $user;

        if(User::destroy($user->id)) {

            return redirect()->back()
                        ->with('success',''.$deleted_rec->name.' user deleted successfully');
          } else {
            return redirect()->route('admin_users')
                        ->with('error','Please try again!');
        }
    }

}
