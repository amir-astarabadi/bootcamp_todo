<?php

namespace Tests\Feature\Api\UserController;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_happy_path(): void
    {
        $user = User::factory()->create();

        $profile = Profile::factory()->forUser($user)->create();

        $response = $this->actingAs($user)->getJson(route('api.users.show'));
        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->where('data.id', $user->getKey())
                ->where('data.name', $user->name)
                ->where('data.email', $user->email)
                ->where('data.profile.id', $profile->getKey())
                ->where('data.profile.company', $profile->company)
                ->where('data.profile.ntionality', $profile->ntionality)
                ->etc()
        );
    }
}
