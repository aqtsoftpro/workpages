<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionsCategories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminPermissionsController extends Controller
{
    public function index(){

        $this->authorize('viewAny', Permission::class);
        // DB::enableQueryLog();
        $records = Permission::with('permissionCategory')->get();
        // dd($records);
        // $query = DB::getQueryLog();
        // dd($query);
        
        // // dd($records);
        // foreach($records as $record)
        // {
        //     echo "<pre>";
        //     print_r($record->permissionCategory);
        //     // echo $record->permissionCategory->name;
        //     echo "</pre>";
        //     $record->permissionCategory->name;
        // }
    
        return  view('admin.permissions.index', compact('records'));
    }

    public function create()
    {
        $this->authorize('create', Permission::class);

        $permission_categories = PermissionsCategories::all();

        return view('admin.permissions.create', compact('permission_categories'));
    }

    public function store(Request $request)
    {   
        $this->authorize('create', Permission::class);

        $added_rec = Permission::create([
            'name' => $request->name,
            'status' => $request->status,
            'guard_name' => 'web',
            'permission_category_id' => 1,
            
            'slug' =>  Str::slug($request->name),
        ]);

        if($added_rec)
        {
            return redirect()->route('permissions.index')
                        ->with('success',''.$request->name.' Permission added successfully.');
        }
        else
        {
            return redirect()->route('permissions.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);

        $record = $permission;

        $permission_categories = PermissionsCategories::all();

        return view('admin.permissions.edit', compact('record', 'permission_categories'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        // $permission = Permission::find($id);

        if($permission->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' package updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);

        $deleted_rec = $permission;

        if(Permission::destroy($permission->id)) {

            return redirect()->route('permissions.index')
                        ->with('success',''.$deleted_rec->name.' Permission deleted successfully');
          } else {
            return redirect()->route('permissions.index')
                        ->with('error','Please try again!');
        }
    }

    public function history(){
        return  view('admin.permissions.history');
    }
}
