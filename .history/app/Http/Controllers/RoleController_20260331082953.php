<?php

namespace App\Http\Controllers;

use App\Models\User; // Import User model
use Illuminate\Http\Request;    
use Spatie\Permission\Models\Permission; // Import Permission model
use Spatie\Permission\Models\Role; // Import Role model

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); // Get all roles with their permissions
        return view('users.roles.index', compact('roles')); // Return the view with roles
    }

    public function create()
    {
        $permissions = Permission::all(); // Get all permissions
        return view('users.roles.create', compact('permissions')); // Return the view for creating a role
    }

    public function store(Request $request) 
    {
        $request->validate (['name' => 'required|unique:roles,name', ]);// Validate role name
        $role = Role::create(['name' => $request->name]); // Create the role
        if($request->permissions)
            $role->syncPermissions($request->permissions); // Sync permissions if provided

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); // Clear cached permissions
        
        return redirect()->route('roles.index')->with('success', 'Role created successfully.'); // Redirect with success message

    }

    public function assignForm() {
        $users = User::all(); // Get all users
        $roles = Role::all(); // Get all roles
        return view('users.roles.assign', compact('users','roles')); // Return the view for assigning roles to users 
    }

    public function assign(Request $request) {
        $user = User::findOrFail($request->user_id); // Find the user by ID
        $user->syncRoles($request->role); // Sync the user's roles

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); // Clear cached permissions


        return redirect()->back()->with('success', 'Role Assigned successfully,'); // Redirect back with success message 
    }

    public function edit (Role $role) 
    {
        $permissions = Permission::all(); 
        $rolePermissions = $role->permissions->pluck('name')->toArray(); // Get the permissions of the role as an array
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions')); // Return the view for editing a role
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id, // Validate role name, allowing the current role's name
        ]); 

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions); // Sync permissions if provided

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); // Clear cached permissions

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.'); // Redirect with success message

    }
}
