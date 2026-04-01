<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'comments.user'])
                      ->where('status','done');

        // If the user is staff, only show tasks they are assigned to
        if (!auth()->user()->can('manage-tasks')) {
            $query->where('assigned_to', auth()->id());
        }

        //Optional filters
        if ($request->filled('assignee') && auth()->user()->can('manage-tasks')) {
            $query->where('assigned_to', $request->assignee);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')){
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->latest('updated_at')->paginate(15)->withQueryString(); // Paginate results and keep query string for filters

        //For the assignee filter dropdown(admin only)
        $users = auth()->user()->can('manage-tasks')
            ? App\Models\User::all()
            : collect(); // Get all users for admin, empty collection for staff

        return view('tasks.history', compact('tasks', 'users')); // Return the view with tasks and users for filter dropdown
    }
}
