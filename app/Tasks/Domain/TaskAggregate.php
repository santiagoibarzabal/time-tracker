<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Tasks\Domain\Events\TaskStarted;
use App\Tasks\Domain\Events\TaskStopped;
use App\Tasks\Domain\ValueObjects\TaskId;
use App\Tasks\Domain\ValueObjects\TaskName;
use DateTimeImmutable;

class TaskAggregate
{
    private function __construct(
        private TaskName $name,
        private ?TaskId $id = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function create(
        TaskName $name,
        TaskId $id = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
    ): self {
        return new self(
            $name,
            $id,
            $createdAt,
            $updatedAt,
        );
    }

    public function name(): TaskName
    {
        return $this->name;
    }

    public function id(): ?TaskId
    {
        return $this->id;
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function start(): void
    {
        TaskStarted::dispatch($this->id(), $this->createdAt());
    }

    public function stop(): void
    {
        TaskStopped::dispatch($this->id(), new DateTimeImmutable());
    }
}
