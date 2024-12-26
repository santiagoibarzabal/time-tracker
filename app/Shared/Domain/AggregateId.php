<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface AggregateId
{
    public function __construct(
        int $value,
    );

    public function value(): int;
}
