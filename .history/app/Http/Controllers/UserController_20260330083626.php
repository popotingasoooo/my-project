<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $query = User::query();

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }


        $users = $query->paginate(10)->withQueryString(); // Paginate the results, 10 per page, and keep query parameters in pagination links
        $trashed = User::onlyTrashed()->get(); // Get soft deleted users for restore table

        return view('users.index', compact('users', 'trashed')); // Return the view with users and trashed users
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Get all available roles
        return view('users.create', compact('roles')); // Return the view for creating a user with roles
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roleNames = Role::pluck('name')->toArray(); // Get all role names from database
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:' . implode(',', $roleNames), // Validate role from database
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Password will be hashed by the model
            'role' => $validated['role'], // Set the role
        ]); // Create the user with validated data

        $user->assignRole($validated['role']); // Assign the role to the user

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); // Clear cached permissions

        return redirect()->route('users.index')->with('success', 'User created successfully.'); // Redirect with success message
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */     
    public function edit(User $user)
    {
        $roles = Role::all(); // Get all available roles
        return view('users.edit', compact('user', 'roles')); // Return the view for editing a user with roles
    }                    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $roleNames = Role::pluck('name')->toArray(); // Get all role names from database
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:' . implode(',', $roleNames), // Validate role from database
        ]);
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }
        $user->update($validated); // Update the user with validated data
        return redirect()->route('users.index')->with('success', 'User updated successfully.');

        $user->syncRoles($validated['role']); // Sync the user's roles
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->can('manage-users')) {
            abort(403)->with('error', 'Unauthorized.'); // Return 403 if user doesn't have permission
        }


        $user->delete(); // Delete the user
        return redirect()->route('users.index')
             ->with('success', 'User deleted successfully (can be restored)'); // Redirect with success message
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id) 
    {
        if (!auth()->user()->can('manage-users')) {
            abort(403)->with('error', 'Unauthorized.'); // Return 403 if user doesn't have permission
        }


        $user = User::withTrashed()->findOrFail($id); // Find the user including soft-deleted ones
        $user->restore(); // Restore the user
        return redirect()->route('users.index')
                ->with('success', 'User restored successfully.'); // Redirect with success message
    }
}
