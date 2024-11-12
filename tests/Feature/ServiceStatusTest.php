<?php

use FateelTech\TaqnyatSmsLaravel\Facades\TaqnyatSms;
use Illuminate\Support\Facades\Http;

it('retrieves service status successfully', function () {
    // Fake the API response
    $body = $this->getFixture('service-status.json');

    Http::fake([
        'https://api.taqnyat.sa/system/status' => Http::response($body),
    ]);

    $this->assertEquals('All Services are Operational', TaqnyatSms::getServiceStatus()->status->getDescription());
});
