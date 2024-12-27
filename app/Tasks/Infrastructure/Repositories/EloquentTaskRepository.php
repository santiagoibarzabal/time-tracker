<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Repositories;

use App\Tasks\Domain\Exceptions\TaskNotFound;
use App\Tasks\Domain\Repository\TaskRepository;
use App\Tasks\Domain\TaskAggregate;
use App\Tasks\Domain\ValueObjects\TaskId;
use App\Tasks\Domain\ValueObjects\TaskName;
use App\Tasks\Infrastructure\Repositories\Models\Task;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class EloquentTaskRepository implements TaskRepository
{
    /**
     * @throws TaskNotFound
     */
    public function find(TaskName $taskName): TaskAggregate
    {
        $task = Task::query()->where('name', $taskName->value())->first();
        if (! $task) {
            throw new TaskNotFound('Task not found');
        }
        $updatedAt = $task->updated_at !== null ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $task->updated_at) : null;

        return TaskAggregate::create(
            $taskName,
            new TaskId($task->id),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $task->created_at),
            $updatedAt,
        );
    }

    public function save(TaskAggregate $taskAggregate): TaskAggregate
    {
        $task = $taskAggregate->id()?->value() ? Task::query()->find($taskAggregate->id()->value()) : new Task;
        $task->fill([
            'name' => $taskAggregate->name()->value(),
        ]);
        $task->save();
        $updatedAt = $task->updated_at !== null ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $task->updated_at) : null;

        return TaskAggregate::create(
            $taskAggregate->name(),
            new TaskId($task->id),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $task->created_at),
            $updatedAt
        );
    }

    public function hasActiveEntries(TaskId $id): bool
    {
        return DB::table('task_entries')
            ->where('task_id', $id->value())
            ->whereNull('stopped_at')
            ->exists();
    }
}
