<?php

declare(strict_types=1);

namespace App\TaskStatistics\Domain\ValueObjects;

enum TaskStatus: string
{
    case STARTED = 'started';
    case STOPPED = 'stopped';
}
