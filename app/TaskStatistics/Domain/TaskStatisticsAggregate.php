<?php

declare(strict_types=1);

namespace App\TaskStatistics\Domain;

use App\TaskStatistics\Domain\ValueObjects\TaskId;
use App\TaskStatistics\Domain\ValueObjects\TaskName;
use App\TaskStatistics\Domain\ValueObjects\TaskStatus;
use App\TaskStatistics\Domain\ValueObjects\TimeElapsedToday;
use DateTimeImmutable;

class TaskStatisticsAggregate
{
    private function __construct(
        private readonly TaskId $taskId,
        private TaskName $taskName,
        private TaskStatus $status,
        private readonly TimeElapsedToday $timeElapsedToday,
        private readonly DateTimeImmutable $firstStartedAt,
        private readonly ?DateTimeImmutable $lastStoppedAt = null,
    ) {}

    public static function create(
        TaskId $taskId,
        TaskName $taskName,
        TaskStatus $status,
        TimeElapsedToday $timeElapsedToday,
        DateTimeImmutable $firstStartedAt, ?DateTimeImmutable $lastStoppedAt = null,
    ): TaskStatisticsAggregate {
        return new self($taskId, $taskName, $status, $timeElapsedToday, $firstStartedAt, $lastStoppedAt);
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    public function taskName(): TaskName
    {
        return $this->taskName;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function timeElapsedToday(): TimeElapsedToday
    {
        return $this->timeElapsedToday;
    }

    public function firstStartedAt(): DateTimeImmutable
    {
        return $this->firstStartedAt;
    }

    public function lastStoppedAt(): ?DateTimeImmutable
    {
        return $this->lastStoppedAt;
    }
}
