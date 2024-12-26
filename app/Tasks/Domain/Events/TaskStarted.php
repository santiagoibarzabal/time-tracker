<?php

namespace App\Tasks\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use App\Tasks\Domain\ValueObjects\TaskId;
use DateTimeImmutable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStarted extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly TaskId $taskId,
        private readonly DateTimeImmutable $createdAt,
    ) {
        parent::__construct(
            $this->taskId,
            $this->createdAt,
        );
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
