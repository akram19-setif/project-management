<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::redirect('/', "/dashboard")->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::resource('project', ProjectController::class);
    Route::resource('task', TaskController::class);
    Route::resource('user', UserController::class);
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
