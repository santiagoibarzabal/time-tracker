<?php

use App\TaskEntries\Infrastructure\Repositories\Models\TaskEntry;
use App\Tasks\Infrastructure\Repositories\Models\Task;

it('starts and stops a task via console command', function () {
    $this->artisan('task:start testing');
    $task = Task::query()->where('name', 'testing')->first();
    expect(TaskEntry::query()->where('task_id', $task->id)->count())->toBe(1);
    $this->artisan('task:stop testing');
    expect(TaskEntry::query()->where('task_id', $task->id)->count())->toBe(1)
        ->and(TaskEntry::query()->where('task_id', $task->id)->orderBy('created_at')->first()->stopped_at)->toBeString();
});

