<?php

use App\Http\Controllers\Api\RegitsterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegitsterController::class)->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'show'])->name('users.show');
});
