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
        
        // DB::enableQueryLog();
        $records = Permission::all();
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

        $permission_categories = PermissionsCategories::all();

        return view('admin.permissions.create', compact('permission_categories'));
    }

    public function store(Request $request)
    {   

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

    public function edit(string $id)
    {
        $record = Permission::find($id);

        $permission_categories = PermissionsCategories::all();

        return view('admin.permissions.edit', compact('record', 'permission_categories'));
    }

    public function update(Request $request, string $id)
    {

        $permission = Permission::find($id);

        if($permission->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' package updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(string $id)
    {
        $deleted_rec = Permission::find($id);

        if(Permission::destroy($id)) {

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
