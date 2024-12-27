<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Service;

use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskCannotBeStartedWithActiveEntries;
use App\Tasks\Domain\Exceptions\TaskNotFound;
use App\Tasks\Domain\Repository\TaskRepository;
use App\Tasks\Domain\TaskAggregate;
use App\Tasks\Domain\ValueObjects\TaskName;

readonly class StartTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {}

    /**
     * @throws TaskCannotBeStartedWithActiveEntries
     * @throws InvalidTaskName
     */
    public function execute(TaskName $taskName): void
    {
        try {
            $task = $this->taskRepository->find($taskName);
        } catch (TaskNotFound) {
            $task = TaskAggregate::create($taskName);
            $task = $this->taskRepository->save($task);
        }
        if ($this->taskRepository->hasActiveEntries($task->id())) {
            throw new TaskCannotBeStartedWithActiveEntries('Task cannot be started with active entries');
        }
        $task->start();
    }
}
