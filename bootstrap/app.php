<?php

use App\Tasks\Infrastructure\Console\Commands\StartTask;
use App\Tasks\Infrastructure\Console\Commands\StopTask;
use App\TaskStatistics\Infrastructure\Console\Commands\ListDailyTaskStats;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withCommands([
            ListDailyTaskStats::class,
            StartTask::class,
            StopTask::class,
        ]
    )
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
