<?php

namespace Tests\Feature\Api\BoardController;

use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_auth_user_can_create_board(): void
    {
        $this->login();
        $input = ['name' => 'new board'];
        $response = $this->postJson(route('api.boards.store'), $input);

        $response->assertOk();
        $this->assertDatabaseHas('boards', [...$input, 'creator_id' => $this->authUser->getKey()]);
    }
}
