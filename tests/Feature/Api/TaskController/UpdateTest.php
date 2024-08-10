<?php

namespace Api\TaskController;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use App\Notifications\Tasks\TaskNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    public function testAuthUserCanUpdateATask(): void
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $this->login();

        $task = Task::factory()
            ->create([
            'creator_id' => $this->authUser->id
        ]);

        $users= User::factory()
            ->count(4)
            ->create();

        foreach ($users as $user) {
            $task->users()->attach($user->id);
        }

        $updatedData = [
            'title' => 'updated title',
            'description' => 'This is updated description'
        ];


        $this
            ->putJson(route('api.tasks.update', $task->id), $updatedData)
            ->assertStatus(200)
            ->assertJson(function(AssertableJson $json){
                $json->whereType('data.id', 'integer');
                $json->whereType('data.title', 'string');
                $json->whereType('data.description', 'string');
                $json->whereType('data.due_date', 'string');
            });

        $this->assertDatabaseHas('tasks', $updatedData);

        foreach ($users as $user){
            Notification::assertSentTo($user, TaskNotification::class, function($notification) use ($user, $task){
                return $notification->task->id === $task->id;
            });
        }

    }

    public function testAuthUserCanGetNotifyOnTelegram(): void
    {
        Notification::fake();

        $this->login();

        $task = Task::factory()
            ->create([
                'creator_id' => $this->authUser->id
            ]);

        $users= User::factory()
            ->count(4)
            ->create();

        foreach ($users as $user) {
            $task->users()->attach($user->id);
        }

        Notification::send($users, new TaskNotification($task));

        foreach ($users as $user){
            Notification::assertSentTo($user, TaskNotification::class,
            function ($notification) use ($task, $user) {
                $telegram = $notification->toTelegram($user);
                return $telegram->toArray()['text'] === "Task has been updated!";
            });
        }

    }

    public function testAuthUserCannotUpdateATaskOnWrongData(): void
    {
        $this->login();


        $updatedData = [
            'title' => 'updated title',
            'description' => 'This is updated description'
        ];


        $this
            ->putJson(route('api.tasks.update', 2), $updatedData)
            ->assertStatus(404);

    }
}
