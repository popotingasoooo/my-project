<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions(); // Clear cached permissions
        
        foreach (['manage-users','view-users','manage-roles',
            'view-roles','view-logs'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]); // Create permissions if they don't exist
        }

        $admin = Role::firstorCreate(['name' => 'admin']); // Create admin role if it doesn't exist
        $staff = Role::firstorCreate(['name' => 'staff']); // Create staff role if it doesn't exist

        $admin->syncPermissions(Permission::all()); // Assign all permissions to admin
        $staff->syncPermissions([]); // Assign no special permissions to staff

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' =>Hash::make('password'), 'role' => 'admin'] // Create admin user with hashed password
        );
        $adminUser->assignRole($admin); // Assign admin role to the user

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Staff', 'password' => Hash::make('password'), 'role' => 'staff'] // Create staff user with hashed password
        );
        $staffUser->assignRole($staff); // Assign staff role to the user


    }

}
