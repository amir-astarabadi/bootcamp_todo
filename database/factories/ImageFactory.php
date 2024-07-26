<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profile = Profile::factory()->create();
        return [
            'imageable_type' => get_class($profile),
            'imageable_id' => $profile->getKey(),
            'address' => 'some text',
        ];
    }

    public function forImageable(Model $model)
    {
        return $this->state([
            'imageable_type' => get_class($model),
            'imageable_id' => $model->getKey(),
        ]);
    }
}
