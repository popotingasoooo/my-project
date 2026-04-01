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
    public function index(Request $request)
{
    $view = $request->get('view', 'board');

    if ($view === 'history') {
        $query = Task::with(['assignee', 'creator', 'comments.user'])
                     ->where('status', 'done');

        if (!auth()->user()->can('manage-tasks')) {
            $query->where('assigned_to', auth()->id());
        }
        if ($request->filled('assignee') && auth()->user()->can('manage-tasks')) {
            $query->where('assigned_to', $request->assignee);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->latest('updated_at')->paginate(15)->withQueryString();
        $users = auth()->user()->can('manage-tasks') ? User::all() : collect();

        // Pass empty collections for board variables so Blade doesn't error
        $todo = collect();
        $inProgress = collect();
        $done = collect();

        return view('tasks.index', compact('view', 'tasks', 'users', 'todo', 'inProgress', 'done'));
    }

    // Board view
    $tasks = Task::with('assignee')
                 ->where(function($q) {
                     if (!auth()->user()->can('manage-tasks')) {
                         $q->where('assigned_to', auth()->id());
                     }
                 })
                 ->get()
                 ->groupBy('status');

    $todo       = $tasks->get('todo', collect());
    $inProgress = $tasks->get('in_progress', collect());
    $done       = $tasks->get('done', collect());

    // Pass empty paginator for history variables so Blade doesn't error
    $tasks = collect();
    $users = collect();

    return view('tasks.index', compact('view', 'todo', 'inProgress', 'done', 'tasks', 'users'));
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
    // Staff-only: Update just the status (kanban drag/click)
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]); // Update only the status of the task

        return redirect()->route('tasks.index')
            ->with('success', 'Task status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    //Delete task (admin only)
    public function destroy(Task $task)
    {
        $task->delete(); // Delete the task

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.'); // Redirect to task index with success message
    }
}
