<?php

use App\Tasks\Infrastructure\Controllers\StartTaskHttpController;
use App\Tasks\Infrastructure\Controllers\StopTaskHttpController;
use App\TaskStatistics\Infrastructure\Controllers\ListDailyTaskStatsHttpController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [ListDailyTaskStatsHttpController::class, 'index']);
Route::post('/tasks/{name}', [StartTaskHttpController::class, 'start']);
Route::put('/tasks/{name}', [StopTaskHttpController::class, 'stop']);
