<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Controllers;

use App\Tasks\Application\StartTaskTimerUseCase;
use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskCannotBeStartedWithActiveEntries;

readonly class StartTaskHttpController
{
    public function __construct(
        private StartTaskTimerUseCase $useCase,
    ) {}

    /**
     * @throws InvalidTaskName
     */
    public function start(string $name)
    {
        if (empty('name') || strlen($name) > 50) {
            return redirect()->back()->withErrors(['name' => 'Invalid name']);
        }
        try {
            $this->useCase->execute($name);
        } catch (TaskCannotBeStartedWithActiveEntries) {
            return redirect()->back()->withErrors(['name' => 'Task cannot be started with a active entries']);
        }
    }
}
