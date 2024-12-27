<?php

declare(strict_types=1);

namespace App\TaskEntries\Domain\Services;

use App\TaskEntries\Domain\Exceptions\NoEntriesFound;
use App\TaskEntries\Domain\Repository\TaskEntryRepository;
use App\TaskEntries\Domain\ValueObjects\TaskId;
use DateTimeImmutable;

readonly class StopTaskEntryService
{
    public function __construct(
        private TaskEntryRepository $taskEntryRepository,
    ) {}

    /**
     * @throws NoEntriesFound
     */
    public function execute(TaskId $taskId, DateTimeImmutable $stoppedAt): void
    {
        $taskEntries = $this->taskEntryRepository->list($taskId, 20, 0);
        if (empty($taskEntries)) {
            throw new NoEntriesFound;
        }
        foreach ($taskEntries as $entry) {
            if ($entry->isCurrentlyInProgress()) {
                $entry = $entry->stop($stoppedAt);
                $this->taskEntryRepository->save($entry);
                break;
            }
        }
    }
}
