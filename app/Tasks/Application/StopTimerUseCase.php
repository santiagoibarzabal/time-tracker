<?php

declare(strict_types=1);

namespace App\Tasks\Application;

use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskNotFound;
use App\Tasks\Domain\Repository\TaskRepository;
use App\Tasks\Domain\ValueObjects\TaskName;

readonly class StopTimerUseCase
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {}

    /**
     * @throws InvalidTaskName
     * @throws TaskNotFound
     */
    public function execute(string $taskName): void
    {
        $taskName = new TaskName($taskName);
        $task = $this->taskRepository->find($taskName);
        $task->stop();
        $this->taskRepository->save($task);
    }
}
