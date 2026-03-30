<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SpatieActivitylog\Traits\LogsActivity;
use SpatieActivitylog\LogOptions;

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

}
