<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCSVJob;
use Illuminate\Console\Command;

/**
 * Class ProcessCommand
 * @package App\Console\Commands
 */
class ProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dpip:process {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->option('path');
        // visualize unzipping progress
        $progress = $this->output->createProgressBar();
        $progress->start();
        // dispatch csv process job
        ProcessCSVJob::dispatch($path, $progress);
        $progress->finish();
        $this->info('File processed completed!');
    }
}
