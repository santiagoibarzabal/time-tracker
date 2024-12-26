<?php

declare(strict_types=1);

namespace App\TaskEntries\Domain;

use App\TaskEntries\Domain\ValueObjects\TaskEntryId;
use App\TaskEntries\Domain\ValueObjects\TaskId;
use DateTimeImmutable;

class TaskEntryAggregate
{
    private function __construct(
        private readonly TaskId $taskId,
        private readonly DateTimeImmutable $startedAt,
        private ?DateTimeImmutable $stoppedAt = null,
        private readonly ?TaskEntryId $id = null,
    ) {
    }

    public static function create(
        TaskId $taskId,
        DateTimeImmutable $startedAt,
        DateTimeImmutable|null $stoppedAt = null,
        TaskEntryId $id = null,
    ): TaskEntryAggregate {
        return new self($taskId, $startedAt, $stoppedAt, $id);
    }

    public function id(): ?TaskEntryId
    {
        return $this->id;
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    public function startedAt(): DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function stoppedAt(): ?DateTimeImmutable
    {
        return $this->stoppedAt;
    }

    public function stop(DateTimeImmutable $stoppedAt): self
    {
        return new self($this->taskId, $this->startedAt, $stoppedAt, $this->id);
    }

    public function isCurrentlyInProgress(): bool
    {
        return $this->stoppedAt === null;
    }
}


