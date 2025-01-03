<?php

declare(strict_types=1);

namespace App\Shared\Domain\Events;

use App\Shared\Domain\AggregateId;
use DateTimeImmutable;

abstract class DomainEvent
{
    protected AggregateId $aggregateId;

    private DateTimeImmutable $createdAt;

    protected function __construct(
        AggregateId $aggregateId,
        DateTimeImmutable $createdAt,
    ) {
        $this->aggregateId = $aggregateId;
        $this->createdAt = $createdAt;
    }

    public function aggregateId(): AggregateId
    {
        return $this->aggregateId;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
