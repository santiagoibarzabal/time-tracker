<?php

declare(strict_types=1);

namespace App\Tasks\Application;


use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskCannotBeStartedWithActiveEntries;
use App\Tasks\Domain\Service\StartTaskService;
use App\Tasks\Domain\ValueObjects\TaskName;

readonly class StartTaskTimerUseCase
{
    public function __construct(
        private StartTaskService $startTaskService,
    ) {}

    /**
     * @throws InvalidTaskName
     * @throws TaskCannotBeStartedWithActiveEntries
     */
    public function execute(string $taskName): void
    {
        $taskName = new TaskName($taskName);
        $this->startTaskService->execute($taskName);
    }
}
