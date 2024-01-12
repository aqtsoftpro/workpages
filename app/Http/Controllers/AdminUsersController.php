<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class AdminUsersController extends Controller
{
    public function index(){

        $job_seekers =  Role::find(2)->users;
        return view('admin.users.index', compact('job_seekers'));
    }

    public function companies() {

        $employers =  Role::find(3)->users()->with('company')->get();
        return view('admin.users.companies', compact('employers'));
    }

    public function admin_users() {



        $roles =  Role::get()->toArray();

        $admin_user = array();
        foreach($roles as $role)
        {

            if($role['name'] == 'Super Admin' || $role['name'] == 'Job Seeker' || $role['name'] == 'Employer')
            {
                continue;
            }

            $records =  Role::find($role['id'])->users;
        }


        return view('admin.users.admin_user', compact('records'));
    }

    public function create()
    {

        $roles = Role::get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)

    {
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

    public function edit(string $id)
    {
        $record = User::find($id);

        $user_roles = Role::get();


        $user = User::find($id);




        return view('admin.users.edit', compact('record', 'user_roles'));
    }

    public function update(Request $request, string $id)
    {
        $update_user = User::find($id);

        if($request['password'] != '')
        {
            $hased_passwoed = bcrypt($request['password']);
            $request['password'] = $hased_passwoed;

            $update_user->update([
                'name' => $request['name'],
                'password' => $request->password
            ]);
        }
        else
        {
            $update_user->update([
                'name' => $request['name'],
            ]);
        }

        if($request->role)
        {
            foreach($request->role as $role)
            {
                $adminUserRole = Role::find($role);

                $user = User::find($id);

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

    public function destroy(string $id)
    {
        $deleted_rec = User::find($id);

        if(User::destroy($id)) {

            return redirect()->route('admin_users')
                        ->with('success',''.$deleted_rec->name.' user deleted successfully');
          } else {
            return redirect()->route('admin_users')
                        ->with('error','Please try again!');
        }
    }

}
