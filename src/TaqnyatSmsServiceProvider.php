<?php

namespace FateelTech\TaqnyatSmsLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TaqnyatSmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('taqnyat-sms-laravel')
            ->hasConfigFile('taqnyat-sms');
    }

    public function packageRegistered(): void
    {
        $this->app->bind(TaqnyatSmsLaravel::class, function () {
            return new TaqnyatSmsLaravel(
                config('taqnyat-sms.endpoint'),
                config('taqnyat-sms.bearer_token'),
                config('taqnyat-sms.sender_name'),
                config('taqnyat-sms.timeout')
            );
        });
    }
}
