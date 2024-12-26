<?php

declare(strict_types=1);

namespace App\TaskStatistics\Application;

use App\TaskStatistics\Domain\Repository\TaskStatisticsRepository;
use App\TaskStatistics\Domain\TaskStatisticsAggregate;
use DateTimeImmutable;

readonly class ListDailyTasksStatsUseCase
{
    public function __construct(
        private TaskStatisticsRepository $taskStatisticsRepository,
    ) {}

    /**
     * @return array<TaskStatisticsAggregate>
     */
    public function execute(): array
    {
        return $this->taskStatisticsRepository->list(new DateTimeImmutable(), 20, 0);
    }
}
