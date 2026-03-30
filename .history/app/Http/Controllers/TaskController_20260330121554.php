<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
        // Kanban board view with tasks grouped by status
    public function index()
    {
        $tasks = Task::with('Assignee')
            ->where(function($q) {
                if (!auth()->user()->can('manage-tasks')){
                    //staff only see their own tasks
                    $q->where('assignee_id', auth()->id());
                }
            })
            ->get();
            ->groupBy('status'); // Group tasks by status for Kanban columns

        $todo = $tasks->get('todo', collect()); // Get tasks with 'todo' status or empty collection
        $inProgress = $tasks->get('in_progress', collect()); // Get tasks with 'in_progress' status or empty collection 
        $done = $tasks->get('done', collect()); // Get tasks with 'done' status or empty collection

        return view('tasks.index',
            compact('todo','inProgress','done')); // Return the view with grouped tasks

    }

    /**
     * Show the form for creating a new resource.
     */
    // Show create form (admin only)
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users')); // Return the view for creating a task with list of users for assignment
    }
    

    /**
     * Store a newly created resource in storage.
     */
    // Save new task (admin only)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
