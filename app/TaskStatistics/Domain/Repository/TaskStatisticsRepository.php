<?php

declare(strict_types=1);

namespace App\TaskStatistics\Domain\Repository;

use App\TaskStatistics\Domain\TaskStatisticsAggregate;
use DateTimeImmutable;

interface TaskStatisticsRepository
{
    /**
     * @return array<TaskStatisticsAggregate>
     */
    public function list(DateTimeImmutable $date, int $limit, int $offset): array;
}
