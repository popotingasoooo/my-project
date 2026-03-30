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
            ->get()
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

        $validated['created_by'] = auth()->id(); // Set the creator of the task to the currently authenticated user
        $validated['status'] = 'todo'; // Set the default status of the task to 'todo'

        Task::create($validated); // Create the task with the validated data

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.'); // Redirect to task index with success message
    }

    /**
     * Display the specified resource.
     */
    //Show single task with comments
    public function show(Task $task)
    {
        $task->load('assignee','creator','comments.user'); // Load related models for the task
        return view('tasks.show', compact('task')); // Return the view for showing task details
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Show edit form (admin only)
    public function edit(Task $task)
    {
        $users= User::all(); // Get all users for assignment
        return view('tasks.edit', compact('task','users')); // Return the view for editing a task with the task details and list of users for assignment

    }

    /**
     * Update the specified resource in storage.
     */
    // Save edits (admin only)
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($validated); // Update the task with the validated data

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.'); // Redirect to task index with success message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
