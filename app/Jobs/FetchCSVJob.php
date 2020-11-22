<?php

namespace App\Jobs;

use Exception;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class FetchCSVJob
 * @package App\Jobs
 */
class FetchCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $url;
    /**
     * @var ProgressBar
     */
    protected static $progress;

    /**
     * Create a new job instance.
     *
     * @param $url
     * @param $progress
     */
    public function __construct($url, &$progress)
    {
        // this is set from the command line request
        $this->url = $url;
        self::$progress = &$progress;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $csvUrl = '';
        try {
            $response = $client->request('GET', $this->url);
            $response = json_decode($response->getBody());

            // get csv download url from response
            if (isset($response->csv) && isset($response->csv->url)) {
                $csvUrl = $response->csv->url;
            }
            self::$progress->advance(50);
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }

        if ($csvUrl) {
            // remove filed if it exists already
            $filePath = storage_path("app/update.gz");
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            try {
                // download the file as a stream so as not to run out of
                // memory during download since it is large file
                // concerns for closing fopen can be ignored see https://github.com/GrahamCampbell/Laravel-Flysystem/issues/46
                Storage::disk('local')
                    ->getDriver()
                    ->writeStream('update.gz', fopen($csvUrl, 'r'));
                self::$progress->advance(50);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
