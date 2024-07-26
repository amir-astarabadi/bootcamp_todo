<?php

namespace Tests\Feature\Api\RegiestrController;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private array $inputs = [];

    public function setUp(): void
    {
        parent::setUp();
        Auth::logout($this->authUser);
        $this->inputs = [
            'user_name' => 'amir@g234.com',
            'credential' => '123456',
            'credential_confirmation' => '123456',
        ];
    }

    public function test_happy_path(): void
    {

        $response = $this->postJson(route('api.register'), $this->inputs);

        $this->assertDatabaseHas('users', ['email' => $this->inputs['user_name']]);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data.auth_token')
                ->where('data.user_id', User::whereEmail($this->inputs['user_name'])->first()->getKey())
                ->etc()
        );
    }

    public function test_user_cannot_register_with_duplicate_email(): void
    {
        $this->login();
        $this->inputs['user_name'] = $this->authUser->email;

        $response = $this->postJson(route('api.register'), $this->inputs);
        // dd($response->json());
        $response->assertStatus(422);
        $this->assertDatabaseCount('users', 1);
    }
}
