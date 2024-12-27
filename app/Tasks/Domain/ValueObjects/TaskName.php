<?php

declare(strict_types=1);

namespace App\Tasks\Domain\ValueObjects;

use App\Tasks\Domain\Exceptions\InvalidTaskName;

readonly class TaskName
{
    /**
     * @throws InvalidTaskName
     */
    public function __construct(
        private string $value,
    ) {
        $this->validate();
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws * @throws InvalidTaskName
     */
    private function validate(): void
    {
        if (empty($this->value) || strlen($this->value) > 50) {
            throw new InvalidTaskName('Task name should not be empty and should have less than 50 characters.');
        }
    }
}
