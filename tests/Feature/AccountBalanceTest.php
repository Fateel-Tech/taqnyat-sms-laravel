<?php

use FateelTech\TaqnyatSmsLaravel\DTO\AccountBalanceDto;
use FateelTech\TaqnyatSmsLaravel\Facades\TaqnyatSms;
use Illuminate\Support\Facades\Http;

it('retrieves account balance successfully', function () {
    // Fake the API response
    $body = $this->getFixture('account-balance.json');

    Http::fake([
        'https://api.taqnyat.sa/account/balance' => Http::response($body),
    ]);

    $response = TaqnyatSms::getAccountBalance();

    expect($response)
        ->toBeInstanceOf(AccountBalanceDto::class)
        ->and($response->getBalance())->toBe('2044.000');
});
