<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity; // Import the Activity model

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-logs'); // Ensure only users with 'view-logs' permission can access this controller
            
    }

    public function index() {
        $logs = Activity::with('causer','subject')
            ->latest()
            ->paginate(20); // Paginate the logs, 20 per page
        return view('activity.index', compact('logs')); // Pass the logs to the view
    }
}
