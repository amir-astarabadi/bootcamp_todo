<?php

namespace Tests\Feature\Api\LoginController;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_exists_user_can_login(): void
    {
        $user = User::factory()->create();
        $inputes = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('api.login'), $inputes);
        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data.auth_token')
                ->etc()
        );
    }

    public function test_exists_user_can_not_login_with_invalid_email(): void
    {
        $inputes = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->postJson(route('api.login'), $inputes);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_exists_user_can_not_login_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $inputes = [
            'email' => $user->email,
            'password' => 'wrong pass',
        ];

        $response = $this->postJson(route('api.login'), $inputes);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
