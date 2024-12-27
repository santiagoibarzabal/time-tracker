<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Controllers;

use App\Tasks\Application\StopTimerUseCase;
use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskCannotBeStartedWithActiveEntries;
use App\Tasks\Domain\Exceptions\TaskNotFound;

readonly class StopTaskHttpController
{
    public function __construct(
        private StopTimerUseCase $useCase,
    ) {
    }

    /**
     * @throws InvalidTaskName
     * @throws TaskNotFound
     */
    public function stop(string $name)
    {
        if (empty('name') || strlen($name) > 50) {
            return redirect()->back()->withErrors(['name' => 'Invalid name']);
        }
        try {
            $this->useCase->execute($name);
        } catch (TaskNotFound) {
            return redirect()->back()->withErrors(['name' => 'Task not found by name']);
        }
    }
}
