<?php

namespace Tests\Unit;

use App\Console\Commands\FetchCommand;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class FetchCSVTest
 * @package Tests\Unit
 */
class FetchCSVTest extends TestCase
{
    /**
     * Test if fetch command class exists and available to run.
     *
     * @test
     */
    public function it_has_fetch_command()
    {
        $this->assertTrue(class_exists(FetchCommand::class));
    }

    /**
     * Test if download completed successfully
     *
     * @test
     */
    public function it_can_fetch_download()
    {
        $this->markTestSkipped('This test is long running because the file needs to be downloaded, uncomment this line to fully run this test');
        // this allows for the file to be downloaded
        // to a temporary location and deleted
        Storage::fake('local');
        $this->artisan('dpip:fetch')
            ->expectsOutput('File download completed!')
            ->assertExitCode(0);
    }

    /**
     * Test if download file exists
     *
     * @test
     */
    public function check_if_download_file_exist()
    {
        $this->assertTrue(file_exists(storage_path('app/update.gz')));
    }

}
