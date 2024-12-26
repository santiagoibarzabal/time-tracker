<?php

declare(strict_types=1);

namespace App\TaskEntries\Domain\ValueObjects;

readonly class TaskEntryId
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
