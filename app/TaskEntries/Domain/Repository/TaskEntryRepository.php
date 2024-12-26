<?php

declare(strict_types=1);

namespace App\TaskEntries\Domain\Repository;

use App\TaskEntries\Domain\TaskEntryAggregate;
use App\TaskEntries\Domain\ValueObjects\TaskId;

interface TaskEntryRepository
{
    /**
     * @return array<TaskEntryAggregate>
     */
    public function list(TaskId $taskId, int $limit, int $offset): array;

    public function save(TaskEntryAggregate $taskEntryAggregate): TaskEntryAggregate;
}
