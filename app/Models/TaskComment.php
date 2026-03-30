<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $fillable = ['task_id', 'user_id', 'body']; // Allow mass assignment for these attributes

    // The task that this comment belongs to
    public function task()
    {
        return $this->belongsTo(Task::class); // Define relationship to Task model
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Define relationship to User model for the author of the comment
    }

}
