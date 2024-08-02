<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Resources\User\RegiesterResource;
use App\Models\User;

class RegitsterController extends Controller
{
    public function __invoke(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());

        return RegiesterResource::make($user);
    }
}
