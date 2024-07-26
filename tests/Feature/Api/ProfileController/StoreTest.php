<?php

namespace Tests\Feature\Api\ProfileController;

use App\Models\Profile;
use App\Models\User;
use Database\Factories\ProfileFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_auth_login_can_update_his_prorile(): void
    {
        $profile = Profile::factory()->create();
    
        $inpute = [
            'company' => fake()->words(2, true),
            'nationality' => fake()->words(1, true),
        ];

        $response = $this->actingAs($profile->owner)->putJson(route('api.profiles.update', ['profile' => $profile->getKey()]), $inpute);
        $response->assertOk();
        $this->assertDatabaseHas('profiles', ['id' => $profile->getKey(), 'user_id' => $profile->owner->getKey(), ...$inpute]);
    }

    public function test_auth_login_can_not_update_other_users_prorile(): void
    {
        $this->login();
        $profile = Profile::factory()->create();
    
        $inpute = [
            'company' => fake()->words(2, true),
            'nationality' => fake()->words(1, true),
        ];

        $response = $this->putJson(route('api.profiles.update', ['profile' => $profile->getKey()]), $inpute);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('profiles', ['id' => $profile->getKey(), 'user_id' => $profile->owner->getKey(), ...$inpute]);
    }
}
