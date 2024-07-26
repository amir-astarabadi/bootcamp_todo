<?php

namespace Tests\Unit\Models\Profile\Relations;

use App\Models\Image;
use App\Models\Profile;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ImageTest extends TestCase
{
    public function test_profile_image_return_an_image_instant(): void
    {
        $profile = Profile::factory()->create();
        $image = Image::factory()->forImageable($profile)->create();

        $this->assertSame($image->id, $profile->image->id);

        $task = Task::factory()->create();
        $image = Image::factory()->forImageable($task)->create();

        $this->assertInstanceOf(Collection::class, $task->images);
    }
}
