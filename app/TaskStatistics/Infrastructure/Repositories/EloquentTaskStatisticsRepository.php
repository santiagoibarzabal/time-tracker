<?php

declare(strict_types=1);

namespace App\TaskStatistics\Infrastructure\Repositories;

use App\TaskStatistics\Domain\Exceptions\InvalidTaskName;
use App\TaskStatistics\Domain\Repository\TaskStatisticsRepository;
use App\TaskStatistics\Domain\TaskStatisticsAggregate;
use App\TaskStatistics\Domain\ValueObjects\TaskId;
use App\TaskStatistics\Domain\ValueObjects\TaskName;
use App\TaskStatistics\Domain\ValueObjects\TaskStatus;
use App\TaskStatistics\Domain\ValueObjects\TimeElapsedToday;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class EloquentTaskStatisticsRepository implements TaskStatisticsRepository
{
    /**
     * @returns array<TaskStatisticsAggregate>
     * @throws InvalidTaskName
     */
    public function list(DateTimeImmutable $date, int $limit, int $offset): array
    {
        $tasks = DB::table('task_entries')
            ->join('tasks', 'task_entries.task_id', '=', 'tasks.id') // Join the tasks table
            ->selectRaw('
                task_entries.task_id,
                tasks.name as task_name,
                MIN(task_entries.started_at) as started_at,
                MAX(task_entries.stopped_at) as stopped_at,
                SUM(TIMESTAMPDIFF(SECOND, task_entries.started_at, COALESCE(task_entries.stopped_at, NOW()))) as total_elapsed_time
            ')
            ->whereDate('task_entries.started_at', $date->format('Y-m-d'))
            ->groupBy('task_entries.task_id', 'tasks.name')
            ->orderBy('task_entries.task_id')
            ->get();
        $taskStatsAggregates = [];
        foreach ($tasks as $task) {
            $status = $task->stopped_at !== null ? TaskStatus::STOPPED : TaskStatus::STARTED;
            $lastStoppedAt = $task->stopped_at ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $task->stopped_at) : null;
            $taskStatsAggregates[] = TaskStatisticsAggregate::create(
                new TaskId($task->task_id),
                new TaskName($task->task_name),
                $status,
                new TimeElapsedToday((int) $task->total_elapsed_time),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $task->started_at),
                $lastStoppedAt
            );
        }
        return $taskStatsAggregates;
    }
}