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

class UpdateTest extends TestCase
{
    private array $inpute = [];

    private ?Profile $profile = null;

    public function setUp():void
    {
        parent::setUp();

        $this->profile = Profile::factory()->create();

        $this->inpute = [
            'company' => fake()->words(2, true),
            'nationality' => fake()->words(1, true),
        ];
    }
    
    public function test_auth_login_can_update_his_prorile(): void
    {

        $response = $this->actingAs($this->profile->owner)->putJson(route('api.profiles.update', ['profile' => $this->profile->getKey()]), $this->inpute);
        $response->assertOk();
        $this->assertDatabaseHas('profiles', ['id' => $this->profile->getKey(), 'user_id' => $this->profile->owner->getKey(), ...$this->inpute]);
    }

    public function test_auth_login_can_not_update_other_users_prorile(): void
    {

        $response = $this->actingAs(User::factory()->create())->putJson(route('api.profiles.update', ['profile' => $this->profile->getKey()]), $this->inpute);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('profiles', ['id' => $this->profile->getKey(), 'user_id' => $this->profile->owner->getKey(), ...$this->inpute]);
    }
}
