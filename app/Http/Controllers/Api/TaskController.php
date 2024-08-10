<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskCreateReqeust;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Notifications\Tasks\TaskNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateReqeust $request)
    {
        $task = auth()->user()->createTask($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): TaskResource
    {
        $task = Task::query()->findOrFail($id);

        $task->title = $request->post('title');
        $task->description = $request->post('description');

        $task->save();

        if (! empty($task->users)) {
            Notification::send($task->users, new TaskNotification($task));
        }
        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
