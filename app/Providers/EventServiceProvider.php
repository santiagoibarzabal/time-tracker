<?php

namespace App\Providers;

use App\TaskEntries\Infrastructure\Subscribers\CreateEntryOnTaskStart;
use App\TaskEntries\Infrastructure\Subscribers\StopEntryOnTaskStop;
use App\Tasks\Domain\Events\TaskStarted;
use App\Tasks\Domain\Events\TaskStopped;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Event::listen(TaskStarted::class, [CreateEntryOnTaskStart::class, 'handle']);
        Event::listen(TaskStopped::class, [StopEntryOnTaskStop::class, 'handle']);
    }
}
