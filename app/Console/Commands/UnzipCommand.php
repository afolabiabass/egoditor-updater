<?php

namespace App\Console\Commands;

use App\Jobs\UnzipCSVJob;
use Illuminate\Console\Command;

/**
 * Class UnzipCommand
 * @package App\Console\Commands
 */
class UnzipCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dpip:unzip {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unzip downloaded update file to extract csv file';

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
        // dispatch unzipping job
        UnzipCSVJob::dispatch($path, $progress);
        $progress->finish();
        $this->info('File unzipping completed!');
    }
}
