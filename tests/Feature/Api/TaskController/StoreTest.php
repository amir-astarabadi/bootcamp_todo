<?php

namespace Tests\Feature\Api\TaskController;

use App\Models\Board;
use App\Models\Image;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_auth_user_can_create_task_with_an_image(): void
    {
        // Arrange
        Storage::fake('public');

        $this->login();

        $input = [
            'title' => fake()->realText(),
            'description' => fake()->realText(),
            'due_date' => now()->addDays(3)->toDateString(),
            'board_id' => Board::factory()->withCreator($this->authUser)->create()->getKey(),
            'image' => UploadedFile::fake()
                ->image('test.jpg')
                ->size(1000),
        ];

        // Act
        $response = $this->postJson(route('api.tasks.store'), $input);

        /** @var Task $task */
        $task = $response->original;

        /** @var Image $image */
        $image = $task->images()->first();

        // Assert
        $response->assertCreated();

        $this->assertInstanceOf(Image::class, $task->images()->first());

        $this->assertEquals(1, $task->images()->count());

        Storage::disk($image->disk)->assertExists($image->address);

        unset($input['image']);

        $this->assertDatabaseHas('tasks', $input);

    }
}
