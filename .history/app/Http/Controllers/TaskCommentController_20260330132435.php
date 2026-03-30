<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskComment;
use App\Models\Task;

class TaskCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'body' => 'required|string', // Validate that the comment body is required and is a string

        ]);

        $task->comments()->create([
            'user_id' => auth()->id(), // Set the user_id to the currently authenticated user
            'body' => $request->body, // Set the body of the comment from the request
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');

    }

    public function destroy(Task $task, TaskComment $comment)
    {
        //only the comment author or admin can delete the comment
        if (auth()->id() !== $comment->user_id
            && !auth()->user()->can('manage-tasks')) {
                abort(403, 'Unauthorized action.'); // Return a 403 error if the user is not authorized to delete the comment
            }

        $comment->delete(); // Delete the comment
        return redirect()->route('tasks.show', $task)->with('success', 'Comment deleted successfully.');
    }