<?php

declare(strict_types=1);

namespace App\TaskEntries\Infrastructure\Repositories;

use App\TaskEntries\Domain\Repository\TaskEntryRepository;
use App\TaskEntries\Domain\TaskEntryAggregate;
use App\TaskEntries\Domain\ValueObjects\TaskEntryId;
use App\TaskEntries\Domain\ValueObjects\TaskId;
use App\TaskEntries\Infrastructure\Repositories\Models\TaskEntry;
use DateTimeImmutable;

class EloquentTaskEntryRepository implements TaskEntryRepository
{
    /**
     * @return array<TaskEntryAggregate>
     */
    public function list(TaskId $taskId, int $limit, int $offset): array
    {
        $taskEntries = [];
        $entries = TaskEntry::query()->where('task_id', $taskId->value())->limit($limit)->offset($offset)->get(['task_id', 'started_at', 'stopped_at', 'id']);
        foreach ($entries as $entry) {
            $stoppedAt = $entry->stopped_at !== null ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $entry->stopped_at) : null;
            $taskEntries[] = TaskEntryAggregate::create(
                new TaskId($entry->task_id),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $entry->started_at),
                $stoppedAt,
                new TaskEntryId($entry->id),
            );
        }

        return $taskEntries;
    }

    public function save(TaskEntryAggregate $taskEntryAggregate): TaskEntryAggregate
    {
        $taskEntry = $taskEntryAggregate->id()?->value() ? TaskEntry::query()->find($taskEntryAggregate->id()->value()) : new TaskEntry;
        $startedAt = $taskEntry->started_at !== null ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $taskEntry->started_at) : $taskEntryAggregate->startedAt();
        $taskEntry->fill([
            'task_id' => $taskEntryAggregate->taskId()->value(),
            'started_at' => $startedAt->format('Y-m-d H:i:s'),
            'stopped_at' => $taskEntryAggregate->stoppedAt()?->format('Y-m-d H:i:s'),
        ]);
        $stoppedAt = $taskEntry->stopped_at !== null ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $taskEntry->stopped_at) : null;
        $taskEntry->save();

        return TaskEntryAggregate::create(
            new TaskId($taskEntry->id),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $taskEntry->started_at),
            $stoppedAt,
            new TaskEntryId($taskEntry->id),
        );
    }
}
