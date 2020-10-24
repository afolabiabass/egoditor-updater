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
    protected $signature = 'dpip:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the dpip update processes';

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
        Artisan::call('dpip:fetch', [], $this->getOutput());
        sleep(1);

        Artisan::call('dpip:unzip', [], $this->getOutput());
        sleep(1);

        Artisan::call('dpip:process', [], $this->getOutput());
    }
}
