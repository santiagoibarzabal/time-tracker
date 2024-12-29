<?php

namespace App\Tasks\Infrastructure\Console\Commands;

use App\Tasks\Application\StopTimerUseCase;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class StopTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:stop {name : The name of the task}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop task with the given name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $useCase = App::make(StopTimerUseCase::class);
        try {
            $useCase->execute($this->argument('name'));
            $this->info('The task "' . $this->argument('name') . '" was stopped successfully.');
        } catch (Exception $exception) {
            $this->error('Error: ' . $exception->getMessage());
        }
    }
}
