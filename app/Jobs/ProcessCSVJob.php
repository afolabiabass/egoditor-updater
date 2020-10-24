<?php

namespace App\Jobs;

use App\Models\Statistics;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;
use League\Csv\Reader;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class ProcessCSVJob
 * @package App\Jobs
 */
class ProcessCSVJob implements ShouldQueue
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
        $this->path = "update.csv";
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
     */
    public function handle()
    {
        // disable logging of database query to ensure
        // memory availability as csv rows are inserted into db
        DB::connection()->disableQueryLog();

        // use Lazy Collection to load csv file for low memory usage
        LazyCollection::make(function () {
            $filePath = storage_path("app/".$this->path);
            $handle = fopen($filePath, 'r');
            while ($line = fgetcsv($handle)) {
                yield array_map('str_getcsv', $line);
            }
        })
        ->chunk(10000) // chunk to reduce insertion queries
        ->each(function ($rows) {
            foreach ($rows as $row) {
                self::$progress->advance();
                Statistics::create([
                    'ip_address' => $row[0][0] ?? null,
                    'subnet_mask' => $row[1][0] ?? null,
                    'continent_code' => $row[2][0] ?? null,
                    'country_code' => $row[3][0] ?? null,
                    'state' => $row[4][0] ?? null,
                    'district' => $row[5][0] ?? null,
                    'city' => $row[6][0] ?? null,
                    'zip_code' => $row[7][0] ?? null,
                    'latitude' => $row[8][0] ?? null,
                    'longitude' => $row[9][0] ?? null,
                    'geo_name_id' => $row[10][0] ?? null,
                    'gmt_offset' => $row[11][0] ?? null,
                    'timezone' => $row[12][0] ?? null,
                    'weather_code' => $row[13][0] ?? null,
                    'isp' => $row[14][0] ?? null,
                    'as_number' => $row[15][0] ?? null,
                    'link_type' => $row[16][0] ?? null,
                    'organization' => $row[17][0] ?? null,
                ]);
            }
        });

        // re-enable logging
        DB::connection()->enableQueryLog();
    }
}
