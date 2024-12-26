<?php

arch()
    ->expect('App\Tasks\Infrastructure\Repositories\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toOnlyBeUsedIn('App\Tasks\Infrastructure\Repositories')
    ->ignoring([
        'App\Models\User',
        'App\Tasks\Infrastructure\Repositories\Models\Task',
        'Database',
    ]);

arch()
    ->expect('App\TaskEntries\Infrastructure\Repositories\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toOnlyBeUsedIn('App\TaskEntries\Infrastructure\Repositories')
    ->ignoring([
        'App\Models\User',
        'App\TaskEntries\Infrastructure\Repositories\Models\TaskEntry',
        'Database',
    ]);
