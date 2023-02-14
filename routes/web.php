<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\TasksController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(!Auth::check()){
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }else{
        return redirect()->route('dashboard');
    }
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// TaskList

Route::get('task_lists', [TaskListController::class, 'index'])
    ->name('task_lists')
    ->middleware('auth');

Route::get('task_lists/create', [TaskListController::class, 'create'])
    ->name('task_lists.create')
    ->middleware('auth');

Route::post('task_lists', [TaskListController::class, 'store'])
    ->name('task_lists.store');

Route::get('task_lists/{taskList}/edit', [TaskListController::class, 'edit'])
    ->name('task_lists.edit')
    ->middleware('auth');

Route::put('task_lists/{taskList}', [TaskListController::class, 'update'])
    ->name('task_lists.update')
    ->middleware('auth');

Route::delete('task_lists/{taskList}', [TaskListController::class, 'destroy'])
    ->name('task_lists.destroy')
    ->middleware('auth');

Route::put('task_lists/{taskList}/restore', [TaskListController::class, 'restore'])
    ->name('task_lists.restore')
    ->middleware('auth');

// Tasks
Route::get('task_lists/{taskList}/task', [TasksController::class, 'index'])
    ->name('task')
    ->middleware('auth');

Route::get('task_lists/{taskList}/task/create', [TasksController::class, 'create'])
    ->name('task.create')
    ->middleware('auth');

Route::post('task_lists/{taskList}/task', [TasksController::class, 'store'])
    ->name('task.store')
    ->middleware('auth');

Route::get('task_lists/{taskList}/task/{task}/edit', [TasksController::class, 'edit'])
    ->name('task.edit')
    ->middleware('auth');

Route::put('task_lists/{taskList}/task/{task}', [TasksController::class, 'update'])
    ->name('task.update')
    ->middleware('auth');

Route::delete('task_lists/{taskList}/task/{task}', [TasksController::class, 'destroy'])
    ->name('task.destroy')
    ->middleware('auth');

Route::put('task_lists/{taskList}/task/{task}/restore', [TasksController::class, 'restore'])
    ->name('task.restore')
    ->middleware('auth');


require __DIR__.'/auth.php';
