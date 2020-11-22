<?php

namespace App\Console\Commands;

use App\Jobs\FetchCSVJob;
use Illuminate\Console\Command;

/**
 * Class FetchCommand
 * @package App\Console\Commands
 */
class FetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:fetch {--url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download recent csv file';

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
        $url = $this->option('url');
        // visualize download progress
        $progress = $this->output->createProgressBar(100);
        $progress->start();
        // dispatch fetching job
        FetchCSVJob::dispatch($url, $progress);
        $progress->finish();
        $this->info('File download completed!');
    }
}
