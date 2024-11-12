# Taqnyat SMS Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fateel-tech/taqnyat-sms-laravel.svg?style=flat-square)](https://packagist.org/packages/fateel-tech/taqnyat-sms-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fateel-tech/taqnyat-sms-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fateel-tech/taqnyat-sms-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fateel-tech/taqnyat-sms-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fateel-tech/taqnyat-sms-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fateel-tech/taqnyat-sms-laravel.svg?style=flat-square)](https://packagist.org/packages/fateel-tech/taqnyat-sms-laravel)

Taqnyat SMS Laravel is a Laravel package for easy integration with the [Taqnyat SMS API](https://dev.taqnyat.sa/ar/doc/sms/), allowing you to send and manage SMS directly within the comfort of your Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require fateel-tech/taqnyat-sms-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="taqnyat-sms-laravel-config"
```

The following config file will be published in `config/taqnyat-sms.php`.

```php
return [
    /**
     * This is the URL where the Taqnyat API is located.
     *
     * In most cases, you won't need to change this value.
     */
    'endpoint' => env('TAQNYAT_API_URL', 'https://api.taqnyat.sa'),

    /**
     * This is the sender name that will be used when sending SMS messages.
     */
    'sender_name' => env('TAQNYAT_API_SENDER_NAME', env('APP_NAME')),

    /**
     * This is the token that will be used to authenticate with the Taqnyat API
     */
    'bearer_token' => env('TAQNYAT_API_TOKEN'),

    /**
     * This is the timeout for the HTTP client
     */
    'timeout' => env('TAQNYAT_API_TIMEOUT', 10),
];
```

Set the `TAQNYAT_API_TOKEN` and `TAQNYAT_API_SENDER_NAME` in your `.env` file.

```dotenv
TAQNYAT_API_SENDER_NAME=*************
TAQNYAT_API_TOKEN=********************************
```

## Usage Examples

```php
use FateelTech\TaqnyatSmsLaravel\Facades\TaqnyatSms;

// Send a message to a single recipient
TaqnyatSms::sendMsg('Hello world', '966500000001');

// Send a message to multiple recipients
TaqnyatSms::sendMsg('Hello world', ['966500000001', '966500000002']);

// Send an advertisement message (appends -AD to the sender name)
TaqnyatSms::asAdvertisement()->sendMsg('Hello world', '966500000001');

// Get the account balance
$accountBalanceInfo = TaqnyatSms::getAccountBalance();
$balance = $accountBalanceInfo->getBalance();
$currency = $accountBalanceInfo->getCurrency();
$expiryDate = $accountBalanceInfo->getExpiryDate();

// Get Taqnyat Service Status
$serviceStatus = TaqnyatSms::getServiceStatus();
$serviceStatus->isUp() // true if the service is up, false otherwise
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Fateel Tech](https://github.com/Fateel-Tech)
- [Faris Alherf](https://github.com/farishrf)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
