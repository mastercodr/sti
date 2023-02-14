<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $requet, TaskList $taskList)
    {
        return Inertia::render('Task/Index', [
            'filters' => Request::all('search', 'trashed'),
            'tasks' => Auth::user()->tasks()
                ->with('taskList')
                ->where('task_list_id', $taskList)
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($task) => [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => $task->phone,
                    'completed' => $task->city,
                    'order' => $task->order,
                    'deleted_at' => $task->deleted_at,
                    'taskList' => $task->taskList ? $task->taskList->only('name') : null,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TaskList $taskList)
    {
        return Inertia::render('Task/Create', [
            'taskList' => $taskList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request, TaskList $taskList)
    {
        Auth::user()->tasks()->create(
            Request::validate([
                'name' => ['required', 'max:50'],
                'description' => ['required', 'max:50'],
                'task_list_id' => ['required', 'integer'],
                'order' => ['required', 'integer'],
            ])
        );

        return Redirect::route('task_lists.edit', ['taskList' => $taskList])->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskList $taskList, Task $task)
    {
        return Inertia::render('Task/Edit', [
            'task' => [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'completed' => $task->completed,
                'task_list_id' => $task->task_list_id,
                'order' => $task->order,
                'deleted_at' => $task->deleted_at,
            ],
            'taskList' => $task->taskList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskList $taskList, Task $task)
    {
        $task->update(
            Request::validate([
                'name' => ['required', 'max:50'],
                'description' => ['sometimes', 'max:50'],
                'completed' => ['sometimes', 'boolean'],
                'order' => ['sometimes', 'integer'],
            ])
        );

        return Redirect::back()->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskList $taskList, Task $task)
    {
        $task->delete();

        return Redirect::back()->with('success', 'Task deleted.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function restore(TaskList $taskList, Task $task)
    {
        $task->restore();

        return Redirect::back()->with('success', 'Task restored.');
    }
}
