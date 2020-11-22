<?php

namespace App\Console;

use App\Console\Commands\FetchCommand;
use App\Console\Commands\ProcessCommand;
use App\Console\Commands\UnzipCommand;
use App\Console\Commands\UpdaterCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchCommand::class,
        ProcessCommand::class,
        UnzipCommand::class,
        UpdaterCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('csv:fetch')->dailyAt('05:00');
         $schedule->command('csv:unzip')->dailyAt('06:00');
         $schedule->command('csv:process')->dailyAt('07:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
