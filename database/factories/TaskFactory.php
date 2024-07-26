<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(random_int(10, 20)),
            'description' => fake()->realText(),
            'due_date' => now()->addDays(5),
            'board_id' => Board::factory(),
            'creator_id' => User::factory(),
        ];
    }
}
