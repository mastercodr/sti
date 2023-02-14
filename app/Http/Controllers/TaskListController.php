<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskListRequest;
use App\Http\Requests\UpdateTaskListRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Task;
use App\Models\TaskList;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('TaskList/Index', [
            'filters' => Request::all('search', 'trashed'),
            'taskLists' => Auth::user()->taskLists()
                ->orderBy('id', 'asc')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($taskList) => [
                    'id' => $taskList->id,
                    'name' => $taskList->name,
                    'deleted_at' => $taskList->deleted_at,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('TaskList/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskListRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskList $taskList)
    {        
        Auth::user()->taskLists()->create(
            Request::validate([
                'name' => ['required', 'max:100']
            ])
        );

        return Redirect::route('task_lists')->with('success', 'Task list created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Inertia\Response;
     */
    public function show(TaskList $taskList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Inertia\Response;
     */
    public function edit(TaskList $taskList)
    {
        return Inertia::render('TaskList/Edit', [
            'taskList' => [
                'id' => $taskList->id,
                'name' => $taskList->name,
                'deleted_at' => $taskList->deleted_at,
                'tasks' => $taskList->tasks()->orderBy('order', 'asc')->get()->map->only('id', 'name', 'completed', 'order', 'task_list_id'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskListRequest  $request
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskList $taskList)
    {
        $taskList->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                //'completed' => ['nullable', 'boolean'],
                //'order' => ['nullable', 'integer']
            ])
        );

        return Redirect::back()->with('success', 'Task list updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskList $taskList)
    {
        $taskList->delete();

        return Redirect::back()->with('success', 'Task list deleted.');
    }

    public function restore(TaskList $taskList)
    {
        $taskList->restore();

        return Redirect::back()->with('success', 'Task list restored.');
    }
}
