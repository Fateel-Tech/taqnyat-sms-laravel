<?php

use FateelTech\TaqnyatSmsLaravel\Tests\TestCase;
use Illuminate\Support\Facades\Http;

uses(TestCase::class)->beforeEach(function () {
    Http::preventStrayRequests();
})->in(__DIR__);
