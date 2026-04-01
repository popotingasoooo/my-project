<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

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
    {
        return Spatie\Activity\LogModelsActivity::where('subject_type', self::class)
            ->where('subject_id', $this->id)
            ->where(function($q){
                $q-whereJsonContains('properties->attributes->status', 'done'); // Check if the status was changed to 'done' in the activity log
            })
            ->with('causer')// Eager load the user who made the change
            ->latest()// Order by latest change
            ->first(); // Get the most recent log entry for when the task was marked as done
    }
    // Calculate time taken to complete the task
    public function timeToComplete(): ?string
    {
        $log = $this->completionLog(); // Get the completion log entry
        if (!$log) return null; // If there is no completion log, return null

        $diff = $this->created_at->diff($log->created_at); // Calculate the difference between task creation and completion time

        if ($diff->days > 0) {
            return $diff->days . ' day(s)'; // Return time taken in days if more than 0 days`
        }  elseif ($diff->h > 0) {
            return $diff->h . ' hour(s)'; // Return time taken in hours if more than 0 hours
        } else {
            return $diff->i . ' minute(s)'; // Return time taken in minutes if more than 0 minutes
        }  

    }


}
