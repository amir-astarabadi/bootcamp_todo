<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    public function show()
    {
        return UserResource::make(auth()->user())->response()->setStatusCode(200);
    }
}
