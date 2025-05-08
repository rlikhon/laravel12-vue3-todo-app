<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register1', [ApiController::class, 'register']);
Route::post('/login1', [ApiController::class, 'login']);

//protected route
Route::group([
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get('/profile1', [ApiController::class, 'profile']);
    Route::get('/logout1', [ApiController::class, 'logout']);
    Route::get("refresh-token1", [ApiController::class, "refreshToken"]);
    //Route::post('/task', [TaskController::class, 'task']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get("refresh-token", [AuthController::class, "refreshToken"]);
    //Route::post('/task', [TaskController::class, 'task']);
});

Route::middleware('auth:sanctum')->group(function () {
    //Route::apiResource('tasks', TaskController::class);
    Route::get('/tasks', [TaskController::class, 'index']);       // List all tasks
    Route::post('/tasks', [TaskController::class, 'store']);      // Create a new task
    Route::get('/tasks/{task}', [TaskController::class, 'show']); // Show a single task (optional if not used)
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // Update a task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});
