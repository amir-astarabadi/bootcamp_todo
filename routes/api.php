<?php

use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegitsterController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegitsterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::get('/users', [UserController::class, 'show'])->name('users.show');
    Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});
