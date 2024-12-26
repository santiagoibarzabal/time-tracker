<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Repository;

use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskNotFound;
use App\Tasks\Domain\TaskAggregate;
use App\Tasks\Domain\ValueObjects\TaskId;
use App\Tasks\Domain\ValueObjects\TaskName;

interface TaskRepository
{
    /**
     * @throws TaskNotFound
     */
    public function find(TaskName $taskName): TaskAggregate;

    /**
     * @throws InvalidTaskName
     */
    public function save(TaskAggregate $taskAggregate): TaskAggregate;

    public function hasActiveEntries(TaskId $id): bool;
}
