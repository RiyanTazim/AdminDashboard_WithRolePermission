<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'View Article',
            'Create Article',
            'Edit Article',
            'Delete Article',
            'View Role',
            'Create Role',
            'Edit Role',
            'Delete Role',
            'View Permission',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            'User List',
            'User Edit',
            'User Delete',
            // Add more as needed
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Optionally assign all permissions to Super Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());
    }
}
