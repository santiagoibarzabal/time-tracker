<?php

namespace App\Providers;

use App\TaskEntries\Domain\Repository\TaskEntryRepository;
use App\TaskEntries\Infrastructure\Repositories\EloquentTaskEntryRepository;
use App\Tasks\Domain\Repository\TaskRepository;
use App\Tasks\Infrastructure\Repositories\EloquentTaskRepository;
use App\TaskStatistics\Domain\Repository\TaskStatisticsRepository;
use App\TaskStatistics\Infrastructure\Repositories\EloquentTaskStatisticsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(TaskStatisticsRepository::class, function () {
            return new EloquentTaskStatisticsRepository;
        });
        $this->app->singleton(TaskRepository::class, function () {
            return new EloquentTaskRepository;
        });
        $this->app->singleton(TaskEntryRepository::class, function () {
            return new EloquentTaskEntryRepository;
        });
    }
}
