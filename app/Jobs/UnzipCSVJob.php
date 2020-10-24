<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class UnzipCSVJob
 * @package App\Jobs
 */
class UnzipCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $path;
    /**
     * @var ProgressBar
     */
    protected static $progress;

    /**
     * Create a new job instance.
     *
     * @param $path
     * @param $progress
     */
    public function __construct($path, &$progress)
    {
        $this->path = "update.gz";
        // use path if set else use default
        // this is set from the command line request
        if ($path) {
            $this->path = $path;
        }
        self::$progress = &$progress;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $filePath = storage_path("app/".$this->path);

        // open downloaded gz file throw exception is unable to access file
        $compressedFile = gzopen($filePath, 'rb');
        if (!$compressedFile) {
            throw new Exception('File not found');
        }

        // check is csv file to write to exists and create if doesn't
        $csvFilePath = storage_path("app/update.csv");
        if (!file_exists($csvFilePath)) {
            touch($csvFilePath);
        }

        $csvFile = fopen($csvFilePath, 'wb');
        // stream unzipping and write to csv file.
        while (!gzeof($compressedFile)) {
            self::$progress->advance();
            fwrite($csvFile, gzread($compressedFile, 4096));
        }

        // close open file connections
        gzclose($compressedFile);
        fclose($csvFile);
    }
}
