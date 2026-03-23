<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10); // Paginate users, 10 per page
        return view('users.index', compact('users')); // Return the view with users
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create'); // Return the view for creating a user
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,staff', // Validate role
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Password will be hashed by the model
            'role' => $validated['role'], // Set the role
        ]); // Create the user with validated data
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
        return view('users.edit', compact('user')); // Return the view for editing a user
    }                    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Unique email except for the current user
            'role' => 'required|in:admin,staff' // Validate role
        ]);
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }
        $user->update($validated); // Update the user with validated data
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
