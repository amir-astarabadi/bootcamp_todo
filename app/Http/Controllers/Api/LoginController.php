<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::whereEmail($validated['email'])->first();

        if(is_null($user)){
            return response('invalid credentials', Response::HTTP_FORBIDDEN);
        }

        if(!Hash::check($validated['password'], $user->password)){
            return response('invalid credentials', Response::HTTP_FORBIDDEN);
        }

        return LoginResource::make($user);
    }
}
