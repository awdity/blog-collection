<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $authorRole = Role::create(['name' => 'Author']);
        $userRole = Role::create(['name' => 'User']);

        // Create Permissions
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'add posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        // Assign Permissions to Roles
        $adminRole->givePermissionTo(['view posts', 'add posts', 'edit posts', 'delete posts']);
        $authorRole->givePermissionTo(['view posts', 'add posts', 'edit posts']);
        $userRole->givePermissionTo(['view posts']);
    }
}
