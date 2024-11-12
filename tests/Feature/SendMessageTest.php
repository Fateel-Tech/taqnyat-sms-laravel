<?php

use FateelTech\TaqnyatSmsLaravel\DTO\MessageDataDto;
use FateelTech\TaqnyatSmsLaravel\Exceptions\TaqnyatRequestException;
use FateelTech\TaqnyatSmsLaravel\Facades\TaqnyatSms;
use Illuminate\Support\Facades\Http;

it('sends an SMS message successfully', function () {
    // Fake the API response
    $body = $this->getFixture('message-data.json');

    Http::fake([
        'https://api.taqnyat.sa/v1/messages' => Http::response($body, 201),
    ]);

    $response = TaqnyatSms::sendMsg('Hello, world!', '966500000000');

    expect($response)
        ->toBeInstanceOf(MessageDataDto::class)
        ->and($response->accepted)->toBe('[966500000000,]')
        ->and($response->totalCount)->toBe(1);
});

it('sends an SMS message to multiple recipients successfully', function () {

    $body = $this->getFixture('multiple-message-data.json');

    Http::fake([
        'https://api.taqnyat.sa/v1/messages' => Http::response($body, 201),
    ]);

    $response = TaqnyatSms::sendMsg('Hello, world!', ['966500000000', '966500000001']);

    expect($response)
        ->toBeInstanceOf(MessageDataDto::class)
        ->and($response->accepted)->toBe('[966500000000,966500000001]');
});

it('throws an exception when unauthorized', function () {
    // Fake the API response
    $body = $this->getFixture('unauthorized.json');

    Http::fake([
        'https://api.taqnyat.sa/v1/messages' => Http::response($body, 401),
    ]);

    expect(fn () => TaqnyatSms::sendMsg('Hello, world!', '966500000000'))
        ->toThrow(TaqnyatRequestException::class, 'invalid credentials information');
});

it('throws an exception for unknown errors', function () {
    Http::fake([
        'https://api.taqnyat.sa/v1/messages' => Http::response(['message' => 'Server error occurred'], 500),
    ]);

    expect(fn () => TaqnyatSms::sendMsg('Test message', '1234567890'))
        ->toThrow(TaqnyatRequestException::class, 'Server error occurred');
});
