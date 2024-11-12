<?php

namespace FateelTech\TaqnyatSmsLaravel\Tests;

use FateelTech\TaqnyatSmsLaravel\Facades\TaqnyatSms;
use FateelTech\TaqnyatSmsLaravel\TaqnyatSmsLaravel;
use FateelTech\TaqnyatSmsLaravel\TaqnyatSmsServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * The instance of the TaqnyatSmsLaravel service.
     */
    protected TaqnyatSmsLaravel $taqnyat;

    /**
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            TaqnyatSmsServiceProvider::class,
        ];
    }

    /**
     * @param  Application  $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'TaqnyatSms' => TaqnyatSms::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('taqnyat-sms.endpoint', 'https://api.taqnyat.sa');
        config()->set('taqnyat-sms.bearer_token', 'test_token');
        config()->set('taqnyat-sms.sender_name', 'test_sender');
        config()->set('taqnyat-sms.timeout', 10);
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function getFixture(string $filename): array
    {
        return json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR."{$filename}"), true);
    }
}
