<?php

declare(strict_types=1);

namespace App\TaskStatistics\Infrastructure\Controllers;

use App\TaskStatistics\Application\ListDailyTasksStatsUseCase;
use Illuminate\Http\Request;
use Illuminate\View\View;

readonly class ListDailyTaskStatsHttpController
{
    public function __construct(
        private ListDailyTasksStatsUseCase $useCase,
    ) {}

    public function index(Request $request): View
    {
        $tasks = $this->useCase->execute();
        $response = [];
        foreach ($tasks as $task) {
            $response[] = [
                'name' => $task->taskName()->value(),
                'status' => $task->status()->value,
                'time' => $task->timeElapsed()->toHours() != 0 ? $task->timeElapsed()->toHours() : '-',
                'time_today' => $task->timeElapsedToday()->toHours() != 0 ? $task->timeElapsedToday()->toHours() : '-',
                'first_start' => $task->firstStartedAt()->format('Y-m-d H:i:s'),
                'last_stop' => $task->lastStoppedAt() ? $task->lastStoppedAt()->format('Y-m-d H:i:s') : 'N/A',
            ];
        }
        return view('tasks', [
            'tasks' => $response,
        ]);
    }
}
