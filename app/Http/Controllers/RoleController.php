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
        return view('roles.index', compact('roles')); // Return the view with roles
    }

    public function create()
    {
        $permissions = Permission::all(); // Get all permissions
        return view('roles.create', compact('permissions')); // Return the view for creating a role
    }

    public function store(Request $request) 
    {
        $request->validate (['name' => 'required|unique:roles,name', ]);// Validate role name
        $role = Role::create(['Name' => $request->name]); // Create the role
        if($request->permissions)
            $role->syncPermissions($request->permissions); // Sync permissions if provided
        return redirect()->route('roles.index')->with('success', 'Role created successfully.'); // Redirect with success message

    }

    public function assignForm() {
        $users = User::all(); // Get all users
        $roles = Role::all(); // Get all roles
        return view('roles.assign', compact('users','roles')); // Return the view for assigning roles to users 
    }

    public function assign(Request $request) {
        $user = User::findOrFail($request->user_id); // Find the user by ID
        $user->syncRoles($request->role_id); // Sync the user's roles
        return redirect()->back()->with('success', 'Role Assigned successfully,'); // Redirect back with success message 
    }
}
