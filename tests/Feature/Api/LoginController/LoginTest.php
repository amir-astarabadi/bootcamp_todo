<?php

namespace Tests\Feature\Api\LoginController;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use DatabaseTransactions;

    public function test_exists_user_can_login(): void
    {
        $user = User::factory()->create();
        $inputes = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(route('api.login'), $inputes);
        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data.auth_token')
                ->etc()
        );
    }
}
