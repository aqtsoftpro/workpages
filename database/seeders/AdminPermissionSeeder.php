<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, Permission, Role};

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(2);

        $role = Role::findByName('Super Admin');

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $admin->assignRole([$role->id]);
    }
}
