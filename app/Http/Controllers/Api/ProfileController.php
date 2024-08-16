<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateReqeust;
use App\Http\Resources\User\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function update(ProfileUpdateReqeust $request, Profile $profile)
    {
        $profile->update($request->validated());

        return ProfileResource::make($profile);
    }
}
