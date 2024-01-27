<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminAUsersController extends Controller
{
    public function index(){

        $roles = Role::latest()->get();

        return view('admin.adminusers.index', compact('roles'));
    }

    public function permissions(){

        $permissions = Permission::latest()->get();

        return view('admin.adminusers.permissions', compact('permissions'));
    }
}
