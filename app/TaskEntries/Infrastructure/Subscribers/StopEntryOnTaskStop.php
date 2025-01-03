<?php

declare(strict_types=1);

namespace App\TaskEntries\Infrastructure\Subscribers;

use App\Shared\Domain\Events\DomainEvent;
use App\Shared\Domain\Subscribers\Subscriber;
use App\TaskEntries\Application\StopTaskEntryUseCase;
use App\TaskEntries\Domain\Exceptions\NoEntriesFound;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class StopEntryOnTaskStop implements ShouldQueue, Subscriber
{
    public function __construct(
        private StopTaskEntryUseCase $stopTaskEntryUseCase
    ) {}

    /**
     * @throws NoEntriesFound
     */
    public function handle(DomainEvent $event): void
    {
        $this->stopTaskEntryUseCase->execute($event->aggregateId()->value(), $event->createdAt()->format('Y-m-d H:i:s'));
    }
}
