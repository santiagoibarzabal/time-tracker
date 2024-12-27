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
    ) {
    }
    public function index(Request $request): View
    {
        $tasks = $this->useCase->execute();
        return view('tasks', [
            'tasks' => $tasks
        ]);
    }
}
