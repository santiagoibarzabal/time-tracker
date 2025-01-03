<?php

declare(strict_types=1);

namespace App\TaskEntries\Infrastructure\Subscribers;

use App\Shared\Domain\Events\DomainEvent;
use App\Shared\Domain\Subscribers\Subscriber;
use App\TaskEntries\Application\StartTaskEntryUseCase;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class CreateEntryOnTaskStart implements ShouldQueue, Subscriber
{
    public function __construct(
        private StartTaskEntryUseCase $startTaskEntryUseCase
    ) {}

    public function handle(DomainEvent $event): void
    {
        $this->startTaskEntryUseCase->execute($event->aggregateId()->value(), $event->createdAt()->format('Y-m-d H:i:s'));
    }
}
