<?php

namespace App\Tasks\Infrastructure\Console\Commands;

use App\Tasks\Application\StartTaskTimerUseCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class StartTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:start {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start task with the given name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $useCase = App::make(StartTaskTimerUseCase::class);
        $useCase->execute($this->argument('name'));
    }
}