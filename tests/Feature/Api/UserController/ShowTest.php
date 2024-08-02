<?php

namespace Tests\Feature\Api\UserController;

use App\Models\Profile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_happy_path(): void
    {
        $this->login();

        $profile = Profile::factory()->forUser($this->authUser)->create();

        $response = $this->getJson(route('api.users.show'));
        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) => $json->where('data.id', $this->authUser->getKey())
                ->where('data.name', $this->authUser->name)
                ->where('data.email', $this->authUser->email)
                ->where('data.profile.id', $profile->getKey())
                ->where('data.profile.company', $profile->company)
                ->where('data.profile.ntionality', $profile->ntionality)
                ->etc()
        );
    }
}
