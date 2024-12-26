<?php

arch()
    ->expect('App\Tasks')
    ->toOnlyBeUsedIn([
        'App\Tasks',
        'App\Providers',
        'Database',
    ]);

arch()
    ->expect('App\TaskEntries')
    ->toOnlyBeUsedIn([
        'App\TaskEntries',
        'App\Providers',
        'Database',
    ]);

arch()
    ->expect('App\TaskStatistics')
    ->toOnlyBeUsedIn([
        'App\TaskStatistics',
        'App\Providers',
        'Database',
    ]);
