<?php

declare(strict_types=1);

namespace App\TaskStatistics\Domain\ValueObjects;

use App\Shared\Domain\AggregateId;

readonly class TaskId implements AggregateId
{
    public function __construct(
        private int $value,
    ) {
        $this->validate();
    }

    public function value(): int
    {
        return $this->value;
    }

    private function validate(): void {}
}
