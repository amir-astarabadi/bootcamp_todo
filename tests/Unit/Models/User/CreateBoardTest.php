<?php

namespace Tests\Unit\Models\User;

use App\Models\Board;
use App\Models\User;
use Tests\TestCase;

class CreateBoardTest extends TestCase
{
    public function test_create_board_method_return_board_instance(): void
    {
        $user = User::factory()->create();

        $board = $user->createBoard(['name' => 'board']);

        $this->assertInstanceOf(Board::class, $board);
    }
}
