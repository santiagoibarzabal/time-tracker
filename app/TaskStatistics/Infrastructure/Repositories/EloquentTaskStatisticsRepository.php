<?php

declare(strict_types=1);

namespace App\TaskStatistics\Infrastructure\Repositories;

use App\TaskStatistics\Domain\Exceptions\InvalidTaskName;
use App\TaskStatistics\Domain\Repository\TaskStatisticsRepository;
use App\TaskStatistics\Domain\TaskStatisticsAggregate;
use App\TaskStatistics\Domain\ValueObjects\TaskId;
use App\TaskStatistics\Domain\ValueObjects\TaskName;
use App\TaskStatistics\Domain\ValueObjects\TaskStatus;
use App\TaskStatistics\Domain\ValueObjects\TimeElapsed;
use App\TaskStatistics\Domain\ValueObjects\TimeElapsedToday;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class EloquentTaskStatisticsRepository implements TaskStatisticsRepository
{
    /**
     * @returns array<TaskStatisticsAggregate>
     *
     * @throws InvalidTaskName
     */
    public function list(DateTimeImmutable $date, int $limit, int $offset): array
    {
        $tasks = DB::table('task_entries')
            ->join('tasks', 'task_entries.task_id', '=', 'tasks.id')
            ->selectRaw('
                task_entries.task_id,
                tasks.name as task_name,
                MIN(task_entries.started_at) as first_start_time,
                MAX(task_entries.stopped_at) as last_stop_time,
                (
                    SELECT SUM(TIMESTAMPDIFF(SECOND, te.started_at, te.stopped_at))
                    FROM task_entries as te
                    WHERE te.task_id = task_entries.task_id
                      AND DATE(te.started_at) = ?
                ) as total_elapsed_time_today,
                (
                    SELECT SUM(TIMESTAMPDIFF(SECOND, te.started_at, te.stopped_at))
                    FROM task_entries as te
                    WHERE te.task_id = task_entries.task_id
                ) as total_elapsed_time
            ', [$date->format('Y-m-d')])
            ->groupBy('task_entries.task_id', 'tasks.name')
            ->orderBy('task_entries.task_id')
            ->get();


        $taskStatsAggregates = [];
        foreach ($tasks as $task) {
            $status = $task->last_stop_time !== null ? TaskStatus::STOPPED : TaskStatus::STARTED;
            $lastStoppedAt = $task->last_stop_time ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $task->last_stop_time) : null;
            $taskStatsAggregates[] = TaskStatisticsAggregate::create(
                new TaskId($task->task_id),
                new TaskName($task->task_name),
                $status,
                new TimeElapsed((int) $task->total_elapsed_time),
                new TimeElapsedToday((int) $task->total_elapsed_time_today),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $task->first_start_time),
                $lastStoppedAt
            );
        }

        return $taskStatsAggregates;
    }
}
