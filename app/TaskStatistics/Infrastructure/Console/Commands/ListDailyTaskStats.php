<?php

namespace App\TaskStatistics\Infrastructure\Console\Commands;

use App\TaskStatistics\Application\ListDailyTasksStatsUseCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ListDailyTaskStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of all the tasks with their status, start time, end time and total elapsed time.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $useCase = App::make(ListDailyTasksStatsUseCase::class);
        $tasks = $useCase->execute();
        $tasks = collect($tasks);
        $tableData = $tasks->map(function ($task) {
            return [
                'Task Name' => $task->taskName()->value(),
                'Status' => $task->status()->value,
                'Total Elapsed Time' => $task->timeElapsedToday()->toHours() != 0 ? $task->timeElapsedToday()->toHours() : '-',
                'First Start' => $task->firstStartedAt()->format('Y-m-d H:i:s'),
                'Last Stop' => $task->lastStoppedAt() ? $task->lastStoppedAt()->format('Y-m-d H:i:s') : 'N/A',
            ];
        });
        $this->table(['Task Name', 'Status', 'Total Elapsed Time', 'First Start', 'Last Stop'], $tableData);
    }
}
