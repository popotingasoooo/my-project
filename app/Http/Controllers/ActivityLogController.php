<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity; // Import the Activity model

class ActivityLogController extends Controller
{
    
    public function index() {
        $logs = Activity::with('causer','subject')
            ->latest()
            ->paginate(20); // Paginate the logs, 20 per page
        return view('activity.index', compact('logs')); // Pass the logs to the view
    }
}
