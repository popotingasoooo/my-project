<?php

namespace App\Providers;

use App\Listeners\LogSuccessfulLogin; // Import the LogSuccessfulLogin listener
use Illuminate\Auth\Events\Login; // Import the Login event
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, LogSuccessfulLogin::class); // Register the event listener for successful logins
    }
}
