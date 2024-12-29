<?php

declare(strict_types=1);

namespace App\Shared\Domain\Subscribers;

use App\Shared\Domain\Events\DomainEvent;

interface Subscriber
{
    public function handle(DomainEvent $event): void;
}
