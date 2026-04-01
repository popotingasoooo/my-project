<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Task extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title', 'description', 'status', 'priority', 'due_date', 'assigned_to', 'created_by'
    ]; // Allow mass assignment for all attributes

    protected $casts = [
        'due_date' => 'date', // Cast due_date to a date object
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'priority', 'assigned_to', 'due_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs(); // Log only changes to fillable attributes and only if they are dirty (changed)
    }

    // The user who created the task
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); // Define relationship to User model for creator
    }

    // All comments related to the task
    public function comments()
    {
        return $this->hasMany(TaskComment::class); // Define relationship to TaskComment model for comments 
    }

    // Helper to check if the task is overdue
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed'; // Check if due date is in the past and task is not completed 
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to'); // Define relationship to User model for assignee
    }

    // Find when and who marked this task as done
    public function completionLog()
    {}


}
