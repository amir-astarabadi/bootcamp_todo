<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegitsterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegitsterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'show'])->name('users.show');
});
