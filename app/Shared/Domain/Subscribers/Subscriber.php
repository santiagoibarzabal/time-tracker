<?php

declare(strict_types=1);

namespace App\Shared\Domain\Subscribers;

interface Subscriber
{
    public function handle(mixed $event): void;
}
