<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return UserResource::make(auth()->user())->response()->setStatusCode(200);
    }
}
