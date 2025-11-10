<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Projects: only admins
Route::middleware('auth:sanctum')->group(function () {

    // 🧭 Public (for all authenticated users)
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);

    // 🛡️ Admin only
   // Route::middleware('role:admin')->group(function () {
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    //});
});



// Tasks: only managers
/*Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
});*/

Route::middleware('auth:sanctum')->group(function () {
    // View tasks under a project
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'index']);
    // View a single task
    Route::get('/tasks/{id}', [TaskController::class, 'show']);

    // Manager-only actions
  //  Route::middleware('role:manager')->group(function () {
        Route::post('/projects/{project_id}/tasks', [TaskController::class, 'store']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    //});

    // Manager or assigned user can update
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
});

// Comments & assigned tasks: only users
Route::middleware(['auth:sanctum'])->group(function () {
    // Route::apiResource('comments', CommentController::class);

      Route::get('/tasks/{task_id}/comments', [CommentController::class, 'index']);
    Route::post('/tasks/{task_id}/comments', [CommentController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
