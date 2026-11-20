<?php

namespace Database\Seeders;

use App\Support\AdminMenuPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = array_unique(array_merge(AdminMenuPermissions::names(), [
            'view admin dashboard',
            'manage admins',
            'manage games',
            'manage tournaments',
            'manage members',
            'manage sessions',
            'manage rewards',
            'manage content',
        ]));

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('Admin', 'web');
        $admin->syncPermissions(Permission::all());

        $superAdmin = Role::findOrCreate('SuperAdmin', 'web');
        $superAdmin->syncPermissions(Permission::all());

        Role::findOrCreate('Member', 'web');
    }
}
