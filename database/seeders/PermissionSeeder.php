<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{PermissionsCategories, Role, Permission};
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = PermissionsCategories::where('name', 'Admin Panel')->first();
        $role = Role::where('name', 'Super Admin')->first();
        $adminpermissions = [

            'List Application',
            'View Application',
            'Edit Application',
            'Delete Application',
            'Restore Application',
            'Delete Permanent Application',

            'List Blog',
            'View Blog',
            'Edit Blog',
            'Delete Blog',
            'Restore Blog',
            'Delete Permanent Blog',

            'List Cms',
            'View Cms',
            'Edit Cms',
            'Delete Cms',
            'Restore Cms',
            'Delete Permanent Cms',

            'List Company',
            'View Company',
            'Edit Company',
            'Delete Company',
            'Restore Company',
            'Delete Permanent Company',

            'List Currency',
            'View Currency',
            'Edit Currency',
            'Delete Currency',
            'Restore Currency',
            'Delete Permanent Currency',

            'List Designation',
            'View Designation',
            'Edit Designation',
            'Delete Designation',
            'Restore Designation',
            'Delete Permanent Designation',

            'List Job',
            'View Job',
            'Edit Job',
            'Delete Job',
            'Restore Job',
            'Delete Permanent Job',

            'List Notification',
            'View Notification',
            'Edit Notification',
            'Delete Notification',
            'Restore Notification',
            'Delete Permanent Notification',

            'List Package',
            'View Package',
            'Edit Package',
            'Delete Package',
            'Restore Package',
            'Delete Permanent Package',

            'List Permission',
            'View Permission',
            'Edit Permission',
            'Delete Permission',
            'Restore Permission',
            'Delete Permanent Permission',


            'List Role',
            'View Role',
            'Edit Role',
            'Delete Role',
            'Restore Role',
            'Delete Permanent Role',

            'List Site Settings',
            'View Site Settings',
            'Edit Site Settings',
            'Delete Site Settings',
            'Restore Site Settings',
            'Delete Permanent Site Settings',


            'List Subscription',
            'View Subscription',
            'Edit Subscription',
            'Delete Subscription',
            'Restore Subscription',
            'Delete Permanent Subscription',

            'List User',
            'View User',
            'Edit User',
            'Delete User',
            'Restore User',
            'Delete Permanent User',
        ];

        foreach ($adminpermissions as $permission) {
            $syncedPermission = Permission::create([
                'name' => $permission,
                'guard_name'=> 'web',
                'slug'=> Str::slug($permission),
                'permission_category_id' => $category->id,
            ]);

            if ($syncedPermission) {
                $role->givePermissionTo($syncedPermission->id);
            }
        }
    }
}
