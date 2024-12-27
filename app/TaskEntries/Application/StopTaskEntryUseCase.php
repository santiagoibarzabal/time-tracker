<?php

declare(strict_types=1);

namespace App\TaskEntries\Application;

use App\TaskEntries\Domain\Exceptions\NoEntriesFound;
use App\TaskEntries\Domain\Services\StopTaskEntryService;
use App\TaskEntries\Domain\ValueObjects\TaskId;
use DateTimeImmutable;

readonly class StopTaskEntryUseCase
{
    public function __construct(
        private StopTaskEntryService $stopTaskService,
    ) {}

    /**
     * @throws NoEntriesFound
     */
    public function execute(int $taskId, string $stoppedAt): void
    {
        $taskId = new TaskId($taskId);
        $stoppedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $stoppedAt);
        $this->stopTaskService->execute($taskId, $stoppedAt);
    }
}
