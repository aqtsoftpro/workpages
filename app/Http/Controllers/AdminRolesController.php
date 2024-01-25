<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionsCategories;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminRolesController extends Controller
{
    public function index(){

        $this->authorize('viewAny', Role::class);
        $records = Role::all();

        // foreach($records as $record)
        // {
        //     print_r($record->permissions);
        // }
        // die();

        return  view('admin.roles.index', compact('records'));
    }

    public function create()
    {
        $this->authorize('create', Role::class);

        $permission_categories = PermissionsCategories::all()->toArray();

        $perm_cat = array();
        foreach($permission_categories as $permission_category)
        {
            $perm_cat['per_cat'][$permission_category['id']] = $permission_category['name'];
            $permission = Permission::where('permission_category_id', $permission_category['id'])->get()->toArray();
            $perm_cat['permission'][$permission_category['id']] = $permission;
        }

        return view('admin.roles.create', compact('perm_cat') );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        
        $added_rec = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'slug' =>  Str::slug($request->name),
        ]);

        $last_inserted_id = $added_rec->id;
   
        foreach($request->role as $key => $permission)
            {
                $data = [
                    'permission_id' => $key,
                    'role_id' => $last_inserted_id,
                ];

                $RoleHasPermission = RoleHasPermission::create($data);
            }


        if($added_rec)
        {
            return redirect()->route('roles.index')
                        ->with('success',''.$request->name.' Subscription added successfully.');
        }
        else
        {
            return redirect()->route('roles.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $record = $role;

        $permission_categories = PermissionsCategories::all()->toArray();

        $perm_cat = array();
        foreach($permission_categories as $permission_category)
        {
            $perm_cat['per_cat'][$permission_category['id']] = $permission_category['name'];
            $permission = Permission::where('permission_category_id', $permission_category['id'])->get()->toArray();
            $perm_cat['permission'][$permission_category['id']] = $permission;
        }
        
        $permissions = DB::table('role_has_permissions')->where('role_id', '=', $role->id)->get()->keyBy('permission_id')->toArray();

        return view('admin.roles.edit', compact('record', 'perm_cat', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);
        $roles = $role;

        RoleHasPermission::where('role_id', '=', $role->id)->delete();

        foreach($request->role as $key => $permission)
        {
            $data = [
                'permission_id' => $key,
                'role_id' => $role->id,
            ];

            $RoleHasPermission = RoleHasPermission::create($data);
        }

        if($roles->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' role updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $deleted_rec = $role;

        RoleHasPermission::where('role_id', '=', $role->id)->delete();

        if(Role::destroy($role->id)) {

            return redirect()->route('roles.index')
                        ->with('success',''.$deleted_rec->name.' role deleted successfully');
          } else {
            return redirect()->route('roles.index')
                        ->with('error','Please try again!');
        }
    }

    public function history(){
        return  view('admin.roles.history');
    }
}
