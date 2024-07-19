<?php

namespace Tests\Feature\Api\RegiestrController;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function test_happy_path(): void
    {
        $inputs = [
            'email' => 'amir@g234.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $response = $this->postJson(route('api.register'), $inputs);

        $this->assertDatabaseHas('users', ['email' => $inputs['email']]);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data.auth_token')
                ->where('data.user_id', User::whereEmail($inputs['email'])->first()->getKey())
                ->etc()
        );
    }

    public function test_user_cannot_register_with_duplicate_email(): void
    {
        User::create([
            'email' => 'amir@g234.com',
            'password' => '123456',
        ]);
        $inputs = [
            'email' => 'amir@g234.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $response = $this->postJson(route('api.register'), $inputs);
        $response->assertStatus(422);
        $this->assertDatabaseCount('users', 1);
    }
}
