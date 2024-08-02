<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\User\LoginResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(UserLoginRequest $request)
    {
        $user = User::query()
            ->where('email', '=', $request->validated(['email']))
            ->first();

        if (is_null($user) || ! Hash::check($request->validated(['password']), $user->password)) {
            return response('invalid credentials', Response::HTTP_FORBIDDEN);
        }

        return LoginResource::make($user);
    }
}
