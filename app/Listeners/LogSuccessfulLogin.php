<?php
namespace App\Listeners;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin{
    public function handle(Login $event): void
    {
        $cacheKey = 'login_logged_' . $event->user->id; // Create a unique cache key for the user
        if (cache()->has($cacheKey)) {
            return; // If the cache key exists, skip logging to prevent duplicates
        }

        cache()->put($cacheKey, true, now()->addSeconds(5)); // Set the cache key for 5 seconds

        activity()
            ->causedBy($event->user) // Log the user who logged in
            ->performedOn($event->user) // Log the user model as the subject of the activity
            ->log('User ' . $event->user->name . ' logged in'); // Log descriptive message with user name
    }


}
