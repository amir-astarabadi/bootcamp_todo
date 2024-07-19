<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show()
    {
        return UserResource::make(auth()->user());
    }
}
