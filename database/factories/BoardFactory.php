<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(random_int(1, 3), true),
            'creator_id' => User::factory(),
        ];
    }

    public function withCreator(User $user)
    {
        return $this->state([
            'creator_id' => $user->getKey(),
        ]);
    }
}
