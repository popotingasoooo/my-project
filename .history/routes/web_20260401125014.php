<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskHistoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// User Profile and Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])
        ->name('users.restore')
        ->withTrashed();
    Route::get('roles',[RoleController::class,'index'])
        ->name('roles.index');
    Route::get('roles/create',[RoleController::class,'create'])
        ->name('roles.create');
    Route::post('roles', [RoleController::class,'store'])
        ->name('roles.store');
    Route::get('roles/assign',[RoleController::class,'assignForm'])
        ->name('roles.assign');
    Route::post('roles/assign',[RoleController::class,'assign'])
        ->name('roles.assign.post');
    Route::get('activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity.index');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->name('roles.update');
   //Anyone with view-tasks can see the board and show a task
    Route::get('tasks',[TaskController::class, 'index'])
        ->name('tasks.index')
        ->middleware('can:view-tasks');
    Route::get('tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create')
        ->middleware('can:manage-tasks');
    Route::post('tasks', [TaskController::class, 'store'])
        ->name('tasks.store')
        ->middleware('can:manage-tasks');
    Route::get('tasks/{task}', [TaskController::class, 'show'])
        ->name('tasks.show')
        ->middleware('can:view-tasks');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.status')
        ->middleware('can:update-task-status');
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('tasks.edit')
        ->middleware('can:manage-tasks');
    Route::put('tasks/{task}', [TaskController::class, 'update'])
        ->name('tasks.update')
        ->middleware('can:manage-tasks');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy')
        ->middleware('can:manage-tasks');
    // comments - anyone with view-tasks can  comment
    Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])
        ->name('tasks.comments.store')
        ->middleware('can:view-tasks');
    Route::delete('tasks/{task}/comments/{comment}', [TaskCommentController::class, 'destroy'])
        ->name('tasks.comments.destroy')
        ->middleware('can:view-tasks');
    // Task history - anyone with view-tasks can see the history, but staff only see their own completed tasks
    Route::get('tasks/history', [TaskHistoryController::class, 'index'])
        ->name('tasks.history')
        ->middleware('can:view-tasks');
});

Route::get('activity-logs', [ActivityLogController::class, 'index'])
    ->middleware('can:view-logs') // Ensure only users with 'view-logs' permission can access this route
    ->name('activity.index');


require __DIR__.'/auth.php';
