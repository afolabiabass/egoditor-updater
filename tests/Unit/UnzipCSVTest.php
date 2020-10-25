<?php

namespace Tests\Unit;

use App\Console\Commands\UnzipCommand;
use Tests\TestCase;

/**
 * Class UnzipCSVTest
 * @package Tests\Unit
 */
class UnzipCSVTest extends TestCase
{
    /**
     * Test if unzip command class exists and available to run.
     *
     * @test
     */
    public function it_has_fetch_command()
    {
        $this->assertTrue(class_exists(UnzipCommand::class));
    }

    /**
     * Test if unzipping completed successfully
     *
     * @test
     */
    public function it_can_fetch_download()
    {
        $this->artisan('dpip:unzip')
            ->expectsOutput('File unzipping completed!')
            ->assertExitCode(0);
    }

    /**
     * Test if unzipped file exists
     *
     * @test
     */
    public function check_if_unzipped_file_exist()
    {
        $this->assertTrue(file_exists(storage_path('app/update.csv')));
    }
}
