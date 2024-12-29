<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Controllers;

use App\Tasks\Application\StartTaskTimerUseCase;
use App\Tasks\Domain\Exceptions\InvalidTaskName;
use App\Tasks\Domain\Exceptions\TaskCannotBeStartedWithActiveEntries;
use Illuminate\Http\JsonResponse;

readonly class StartTaskHttpController
{
    public function __construct(
        private StartTaskTimerUseCase $useCase,
    ) {}

    /**
     * @throws InvalidTaskName
     */
    public function start(string $name): JsonResponse
    {
        if (empty('name') || strlen($name) > 50) {
            return response()->json(['error' => 'Invalid name'], 422);
        }
        try {
            $this->useCase->execute($name);
        } catch (TaskCannotBeStartedWithActiveEntries) {
            return response()->json(['error' => 'Task cannot be started with a active entries'], 422);
        }
        return response()->json(['success' => 'Task successfully started'], 200);
    }
}
