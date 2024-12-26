<?php

declare(strict_types=1);

namespace App\TaskEntries\Application;


use App\TaskEntries\Domain\Repository\TaskEntryRepository;
use App\TaskEntries\Domain\TaskEntryAggregate;
use App\TaskEntries\Domain\ValueObjects\TaskId;
use DateTimeImmutable;

readonly class StartTaskEntryUseCase
{
    public function __construct(
        private TaskEntryRepository $taskEntryRepository,
    ) {}

    public function execute(int $taskId, string $startedAt): void
    {
        $startedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $startedAt);
        $entry = TaskEntryAggregate::create(new TaskId($taskId), $startedAt);
        $this->taskEntryRepository->save($entry);
    }
}
