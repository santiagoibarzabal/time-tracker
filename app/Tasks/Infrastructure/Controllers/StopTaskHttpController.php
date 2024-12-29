<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Controllers;

use App\Tasks\Application\StopTimerUseCase;
use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskNotFound;

readonly class StopTaskHttpController
{
    public function __construct(
        private StopTimerUseCase $useCase,
    ) {}

    /**
     * @throws InvalidTaskName
     */
    public function stop(string $name)
    {
        if (empty('name') || strlen($name) > 50) {
            return response()->json(['error' => 'Invalid name'], 422);
        }
        try {
            $this->useCase->execute($name);
        } catch (TaskNotFound) {
            return response()->json(['error' => 'Task not found by name'], 422);
        }
        return response()->json(['success' => 'Task successfully stopped'], 200);
    }
}
