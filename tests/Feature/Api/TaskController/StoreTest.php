<?php

namespace Tests\Feature\Api\TaskController;

use App\Models\Board;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_auth_user_can_create_task(): void
    {
        $this->login();

        $input = [
            'title' => fake()->realText(),
            'description' => fake()->realText(),
            'due_date' => now()->addDays(3)->toDateString(),
            'board_id' => Board::factory()->withCreator($this->authUser)->create()->getKey(),
        ];
        $response = $this->postJson(route('api.tasks.store'), $input);

        $response->assertCreated();
        $this->assertDatabaseHas('tasks', $input);
    }
}
