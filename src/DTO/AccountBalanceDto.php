<?php

namespace FateelTech\TaqnyatSmsLaravel\DTO;

class AccountBalanceDto
{
    public function __construct(
        public int $statusCode,
        public string $accountStatus,
        public string $accountExpiryDate,
        public string $balance,
        public string $currency,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            statusCode: $data['statusCode'],
            accountStatus: $data['accountStatus'],
            accountExpiryDate: $data['accountExpiryDate'],
            balance: $data['balance'],
            currency: $data['currency'],
        );
    }

    public function getStatus(): string
    {
        return $this->accountStatus;
    }

    public function getExpiryDate(): string
    {
        return $this->accountExpiryDate;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
