<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Class UpdaterCommand
 * @package App\Console\Commands
 */
class UpdaterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the csv update processes';

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
        Artisan::call('csv:fetch', [], $this->getOutput());
        sleep(1);

        Artisan::call('csv:unzip', [], $this->getOutput());
        sleep(1);

        Artisan::call('csv:process', [], $this->getOutput());
    }
}
