<?php

namespace Tests\Unit\Models\Relations;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRelationsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_has_many_tasks(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(BelongsToMany::class, $user->tasks());
    }

    // public function test_user_tasks_property_is_instance_of_collection(): void
    // {
    //     $user = User::factory()->create();
    //     $task = Task::factory()->create();

    //     DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => $task->getKey()]);

    //     $this->assertInstanceOf(Collection::class, $user->tasks);
    //     $this->assertCount(1, $user->tasks);
    //     $this->assertSame(1, $user->tasks->count());

    //     foreach($user->tasks as $task){
    //         continue;
    //     }
    // }

    public function test_user_tasks_property_is_instance_of_collection_2(): void
    {
        $this->assertTrue(true);

        $user = User::factory()->create();

        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);

        $user = User::factory()->create();
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);
        DB::table('task_user')->insert(['user_id' => $user->getKey(), 'task_id' => Task::factory()->create()->getKey()]);

        // n + 1
        foreach (User::with('tasks')->get() as $user) {
            foreach ($user->tasks as $task) {
                continue;
            }
        }
    }
}
