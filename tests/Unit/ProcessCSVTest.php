<?php

namespace Tests\Unit;

use App\Console\Commands\ProcessCommand;
use App\Models\Statistics;
use Tests\TestCase;

/**
 * Class ProcessCSVTest
 * @package Tests\Unit
 */
class ProcessCSVTest extends TestCase
{
    /**
     * Test if process command class exists and available to run.
     *
     * @test
     */
    public function it_has_fetch_command()
    {
        $this->assertTrue(class_exists(ProcessCommand::class));
    }

    /**
     * Test if processing csv to db completed successfully
     *
     * @test
     */
    public function it_can_process_csv()
    {
        if (!file_exists(base_path("tests/test.csv"))) {
            $this->markTestSkipped('Test file does not exit. Please copy sample test csv file in test directory');
        }
        // copy test csv file from
        copy(base_path("tests/test.csv"), storage_path("app/test.csv"));
        $this->artisan('dpip:process --path="test.csv"')
            ->expectsOutput('File processed completed!')
            ->assertExitCode(0);
        unlink(storage_path("app/test.csv"));
    }

    /**
     * Test if csv data exists in db
     *
     * @test
     */
    public function check_if_csv_data_exists()
    {
        $dataExists = Statistics::where('ip_address', '0.0.0.0')->exists();
        $this->assertTrue($dataExists);
    }
}
