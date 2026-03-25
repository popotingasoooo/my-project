<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])
        ->name('users.restore')
        ->withTrashed();
});

Route::middleware('auth')->group(function () {
    Route::get('roles',[RoleController::class,'index'])->name('roles.index');
    Route::get('roles/create',[RoleController::class,'create'])->name('roles.create');
    Route::post('roles', [RoleController::class,'store'])->name('roles.store');
    Route::get('roles/assign',[RoleController::class,'assignForm'])->name('roles.assign');
    Route::post('roles/assign',[RoleController::class,'assign'])->name('roles.assign.post');
});

require __DIR__.'/auth.php';
