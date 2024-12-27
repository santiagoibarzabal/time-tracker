<?php

declare(strict_types=1);

namespace App\TaskStatistics\Domain\ValueObjects;

readonly class TimeElapsedToday
{
    public function __construct(
        private int $value,
    ) {}

    public function value(): int
    {
        return $this->value;
    }

    public function toHours(): float
    {
        return $this->value / 60 / 60;
    }
}
