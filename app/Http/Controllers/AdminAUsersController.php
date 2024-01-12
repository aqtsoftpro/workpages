<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminAUsersController extends Controller
{
    public function index(){

        $roles = Role::all();

        return view('admin.adminusers.index', compact('roles'));
    }

    public function permissions(){

        $permissions = Permission::all();

        return view('admin.adminusers.permissions', compact('permissions'));
    }
}
